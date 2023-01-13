'use strict';

const table = document.getElementById('tbl-main');
const tbody = table.tBodies[0];
const lang = JSON.parse(document.getElementById('lang').textContent);
const checkAll = document.getElementById('check-all');
const deleteAllBtn = document.getElementById('delete-all'),
      prevPage = document.getElementById('previous-page'),
      nextPage = document.getElementById('next-page');

let selectedRows = [],
    data = null,
    fetchUrl = `${window.location.href}/get`;
// INIT DATA
const getData = async (url, options) => {
    try
    {
        let opt = options ? options : {};
        let req = await fetch(url, opt);
        const j = await req.json();

        return j;
    }
    catch(err)
    {
        console.error(err);
    }
}

// 


(async () => {
    document.getElementById('loading-table').classList.remove('d-none');

    data = await getData(fetchUrl);
    
    await setTable(data);
    document.getElementById('loading-table').classList.add('d-none');

    // // check all table
    // checkAll.addEventListener('click', checkAllRows);
    // // delete all table
    // deleteAllBtn.addEventListener('click', async e => deleteAllRows(e, {}));
    // seacrh
    const frmSearch = document.forms['search-form'];

    frmSearch.addEventListener('submit', async e => await filterData(e));

    frmSearch.addEventListener('reset', async e => {
        fetchUrl = `${window.location.origin}/customers/get`;
        data = await getData(fetchUrl);
        checkAll.checked = false;
        await setTable(data);
    }); 

    document.getElementById('previous-page').addEventListener('click', async e => {
        if(data.prev_page_url === null) return; 

        e.target.classList.remove('disabled');
        document.getElementById('loading-table').classList.remove('d-none');

        data = await getData(data.prev_page_url);
        await setTable(data);
        document.getElementById('loading-table').classList.add('d-none');
    });

    document.getElementById('next-page').addEventListener('click', async e => {
        if(data.next_page_url === null) return; 

        e.target.classList.remove('disabled');
        document.getElementById('loading-table').classList.remove('d-none');
       
        data = await getData(data.next_page_url);
        await setTable(data);
        document.getElementById('loading-table').classList.add('d-none');
    });

})();


const setTable = async data => {
    tbody.innerHTML = null;
    Array.from(data.data, item => {
        const row = tbody.insertRow();
        const keys = Object.keys(item);

        const cell_0 = row.insertCell(0),
              cell_1 = row.insertCell(1),
              cell_2 = row.insertCell(2),
              cell_3 = row.insertCell(3),
              cell_4 = row.insertCell(4),
              cell_5 = row.insertCell(5);
        
        // Column 0
        cell_0.innerText = item['id'];
        cell_0.dataset.name = 'id';
        cell_0.classList.add('d-none');
        // Column 1
        cell_1.innerText = item['invoice_no'];
        cell_1.dataset.name = 'invoice_no';
        cell_1.classList.add('ps-2');
        // Column 2
        cell_2.innerText = item['customers']['id'];
        cell_2.dataset.name = 'customer_id';
        cell_2.classList.add('d-none');
        // Column 3
        cell_3.innerText = item['customers']['customer_name'];
        cell_3.dataset.name = 'customer_name';
        cell_3.classList.add('ps-2');
        // Column 4
        cell_4.innerHTML = setEmailStatus(+item['invoice_status']);
        cell_4.dataset.name = 'invoice_status';
        cell_4.classList.add('ps-2');
        // Column 5
        cell_5.innerHTML = `<span class="d-flex flex-nowrap flex-grow-0 align-items-center">` +
                                `<a type="button" class="btn btn-sm btn-info btn-circle p-0 m-0 edit_data" data-bs-toggle="tooltip" data-bs-title="Edit" href="${window.location.origin}/customers/${item.id}/edit">` + 
                                    `<i class="fas fa-edit font-reset"></i>` +
                                `</a>` +
                                `<button type="button" class="btn btn-sm btn-danger btn-circle p-0 m-0 ms-1 delete_data" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="deleteConfirmation(event)"><i class="fas fa-trash font-reset"></i></button>` + 
                            `</span>`;
        cell_5.dataset.name = 'invoice_status';
        cell_5.classList.add('ps-2');

        // Column 6
        // const cell_5 = row.insertCell(5);
        // cell_5.innerHTML =  `<span class="d-flex flex-nowrap flex-grow-0 align-items-center">` +
        //                         `<a type="button" class="btn btn-sm btn-info btn-circle p-0 m-0 edit_data" data-bs-toggle="tooltip" data-bs-title="Edit" href="${window.location.origin}/customers/${item.id}/edit">` + 
        //                             `<i class="fas fa-edit font-reset"></i>` +
        //                         `</a>` +
        //                         `<button type="button" class="btn btn-sm btn-danger btn-circle p-0 m-0 ms-1 delete_data" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="deleteConfirmation(event)"><i class="fas fa-trash font-reset"></i></button>` + 
        //                     `</span>`;
        // cell_5.classList.add('ps-1');
    });

    await setPagination(data);
}

const setPagination = async data => {
    var pageNo = document.getElementById('page_no'),
        totalPage = document.getElementById('total_pages');

    // Current Page
    pageNo.innerText = data.current_page;
    // Total Page
    totalPage.innerText = data.last_page;
}

// Delete
const deleteConfirmation = e => {
    const tr = e.target.parentNode.closest('tr');
    const props = [...tr.cells].filter(x => x.dataset.hasOwnProperty('name')).reduce((prev, curr) => Object.assign(prev, {[curr.dataset.name] : curr.innerHTML}), {});

    Swal.fire({
        title: '<h4 class="text-warning">'+ lang.delete.confirm +'</h4>',
        html: '<h5 class="text-warning">' +lang.delete.text+ '</h5>',
        icon: 'warning',
        confirmButtonText: lang.confirmation.yes,
        showCancelButton: true,
        cancelButtonText: lang.confirmation.no
    })
    .then(t => {
        if(!t.value) return;

        loading();
        fetch(`${window.location.origin}/customers/${props.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
            }
        })
        .then(res => {
            Swal.close();
            window.location.reload();
        })
        .catch(err => {
            console.log(err);
        })
    });
}

// Loading
const loading = () => {
    Swal.fire({
        html: 	'<div class="d-flex flex-column align-items-center">'
        + '<span class="spinner-border text-primary"></span>'
        + '<h3 class="mt-2">Loading...</h3>'
        + '<div>',
        showConfirmButton: false,
        width: '14rem'
    });
}

// Filter
const filterData = async e => {
    e.preventDefault();

    let frm = new FormData(e.target);
    let obj = Object.fromEntries(frm.entries());
    let params = new URLSearchParams(obj);

    try 
    {
        fetchUrl = `${window.location.origin}/customers/get?` + params;
        data = await getData(fetchUrl);
        await setTable(data);
    } 
    catch (error) 
    {
        console.log(error);
    }  
} 

// Email Status Text

const setEmailStatus = num => {
    let text = null;
    switch(num)
    {
        case 0:
            return '<span class="bg-warning text-white px-1">DRAFT</span>';
        case 1:
            return '<span class="bg-success text-white px-1">SENT</span>';
        case 2:
            return '<span class="bg-danger text-white px-1">FAILED</span>';
    }

    return text;
}