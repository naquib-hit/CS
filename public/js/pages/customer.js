'use strict';

const table = document.getElementById('tbl-main');
const tbody = table.tBodies[0];
const lang = JSON.parse(document.getElementById('lang').textContent);
const checkAll = document.getElementById('check-all');
const deleteAllBtn = document.getElementById('delete-all');
let selectedRows = [];

// INIT DATA
const getData = async (url, options) => {
    try
    {
        let opt = options ?? {};
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

    const data = await getData(`${window.location.origin}/customers/get`);
    
    //await setTable(data);

    // check all table
    checkAll.addEventListener('click', checkAllRows);
    // delete all table
    deleteAllBtn.addEventListener('click', deleteAllRows);
    // seacrh
    const frmSearch = document.forms['search-form'];

    frmSearch.addEventListener('submit', e => {
        e.preventDefault();

        let frm = new FormData(e.target);
        let obj = [...frm.entries()].reduce((prev, curr) => Object.assign(prev, {[curr[0]]:curr[1]}), {});
        let params = new URLSearchParams(obj);

        getData(`${window.location.origin}/customers/get?` + params)
        .then(res => {
            console.log(res);
        })
        .catch(err => console.log(err));
    });

})()


const setTable = async data => {

    Array.from(data.data, item => {
        const row = tbody.insertRow();
        const keys = Object.keys(item);

        // set id
        row.dataset.id = item.id;
        // Column 1
        const cell_0 = row.insertCell(0);
        cell_0.innerHTML = `<div class="form-check">` +
                                `<input type="checkbox" class="form-check-input check-row" id="row_${item.id}" name="row[]" value="${item.id}">` + 
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

// Check Rowss
const checkAllRows = () => {

    switch(checkAll.checked)
    {
        case true:
            Array.from([...tbody.rows], val => {
                const cb = val.getElementsByClassName('check-row')[0];
                cb.checked = true;
                cb.readonly = true;
                val.classList.add('bg-light');
            });
            break;
        case false:
            Array.from([...tbody.rows], val => {
                const cb = val.getElementsByClassName('check-row')[0];
                cb.checked = false;
                cb.readonly = false;
                val.classList.remove('bg-light');
            });
            break;
    }
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
const filterData = () => {

}   

// Truncate
const deleteAllRows = async opt => {
    opt.method = 'DELETE';
    opt.headers = {
        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
    }
    let params = {};
    let url = `${window.location.href}/truncate`;

    if(!checkAll.checked && selectedRows.length === 0) return;

    if(checkAll.checked)
    {
        params = {};
        selectedRows = [];
        params.rows='all';
        url += '?' + new URLSearchParams(params); 
    }
    
    url = new URL(url);

    return await getData(url.href, opt);
}