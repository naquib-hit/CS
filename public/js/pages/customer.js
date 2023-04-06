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
    fetchUrl = `${window.location.origin}/customers/get`;
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

    // check all table
    checkAll.addEventListener('click', checkAllRows);
    // delete all table
    deleteAllBtn.addEventListener('click', async e => deleteAllRows(e, {}));
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

        // set id
        row.dataset.id = item.id;
        // Column 1
        const cell_0 = row.insertCell(0);
        cell_0.innerHTML = `<div class="form-check">` +
                                `<input type="checkbox" class="form-check-input check-row" id="row_${item.id}" name="row[]" value="${item.id}" onclick="checkRow(event)">` + 
                                `<label for="row_${item.id}" class="form-check-label"></label>` +
                            `</div>`;
        cell_0.classList.add('ps-1');
        // Column 2
        const cell_1 = row.insertCell(1);
        cell_1.dataset.name = keys[0];
        cell_1.innerText = item[keys[0]];
        cell_1.classList.add('d-none');
        // Column 3
        const cell_2 = row.insertCell(2);
        cell_2.dataset.name = 'customer_name';
        cell_2.innerText = item['customer_name'];
        cell_2.classList.add('ps-1');
        // Column 4
        const cell_3 = row.insertCell(3);
        cell_3.dataset.name = 'customer_email';
        cell_3.innerText = item['customer_email'];
        cell_3.classList.add('ps-1');
        // Column 5
        const cell_4 = row.insertCell(4);
        cell_4.dataset.name = 'customer_phone';
        cell_4.innerText = item['customer_phone'];
        cell_4.classList.add('ps-1');
        // Column 6
        const cell_5 = row.insertCell(5);
        cell_5.innerHTML =  `<span class="d-flex flex-nowrap flex-grow-0 align-items-center">` +
                                `<a type="button" class="btn btn-sm btn-info btn-circle p-0 m-0 edit_data" data-bs-toggle="tooltip" data-bs-title="Edit" href="${window.location.origin}/customers/${item.id}/edit">` + 
                                    `<i class="fas fa-edit font-reset"></i>` +
                                `</a>` +
                                `<button type="button" class="btn btn-sm btn-danger btn-circle p-0 m-0 ms-1 delete_data" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="deleteConfirmation(event)"><i class="fas fa-trash font-reset"></i></button>` + 
                            `</span>`;
        cell_5.classList.add('ps-1');
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

// Block Check Row
const checkAllRows = () => {

    switch(checkAll.checked)
    {
        case true:
            Array.from([...tbody.rows], val => {
                const cb = val.getElementsByClassName('check-row')[0];
                cb.checked = true;
                cb.disabled = 'disabled';
                val.classList.add('bg-light');
            });
            document.getElementById('next-page').classList.add('disabled');
            document.getElementById('previous-page').classList.add('disabled');
            break;
        case false:
            Array.from([...tbody.rows], val => {
                const cb = val.getElementsByClassName('check-row')[0];
                cb.checked = false;
                cb.disabled = false;
                val.classList.remove('bg-light');
            });
            document.getElementById('next-page').classList.remove('disabled');
            document.getElementById('previous-page').classList.remove('disabled');
            break;
    }
}

const checkRow = e => {
    e.stopPropagation();
    if(e.target.checked)
        selectedRows.push(e.target.value);
    else 
        selectedRows.splice(selectedRows.indexOf(e.target.value), 1);
    
    console.log(selectedRows);
}
// end block

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

// UNC
const tableLoading = () => {
    
}

// Truncate

const deleteAllRows = async (e, opt) => {
    opt.method = 'DELETE';
    opt.headers = {
        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
    }
    let params = {};
    let uri = `${window.location.href}/truncate`;

    Swal.fire({
        title: '<h4 class="text-warning">'+ lang.delete.confirm +'</h4>',
        html: '<h5 class="text-warning">' +lang.delete.text+ '</h5>',
        icon: 'warning',
        confirmButtonText: lang.confirmation.yes,
        showCancelButton: true,
        cancelButtonText: lang.confirmation.no
    })
    .then(async t => {
        if(!t.value) return;        
        if(!checkAll.checked && selectedRows.length === 0) return;
        
        loading();

        if(checkAll.checked)
        {
            params = {};
            selectedRows = [];
            params.rows='all';
        }
        else
        {
            params = {};
            params.rows = selectedRows.join(',');
        }
    
        const filter = Object.fromEntries((new URL(fetchUrl).searchParams).entries());
    
        if(filter.s_customer_name)
            params.customer_name = filter.s_customer_name;
        if(filter.s_customer_email)
            params.customer_email = filter.s_customer_email;
        if(filter.s_customer_phone)
            params.customer_phone  = filter.s_customer_phone;
    
        uri += '?' + new URLSearchParams(params); 

    
        await getData(uri, opt)
        .then(res => {
           Swal.close();
           window.location.reload();

        })
        .catch(err => console.log(err));
    })
    .catch(err => {
        console.log(err);
    });
    // Klo ga di check abort
    
}
