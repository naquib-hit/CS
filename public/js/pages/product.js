'use strict';

const table = document.getElementById('tbl-product');
const tbody = table.tBodies[0];

// INIT
const getData = async options => {
    try
    {
        let opt = options ?? {};
        let req = await fetch(`${window.location.origin}/products/get`, opt);
        const j = await req.json();

        return j;
    }
    catch(err)
    {
        console.error(err);
    }
}


(async () => {

    const data = await getData();
    await setTable(data.data);

})()

const intToCurrency = angka => {
    const lokal = new Intl.NumberFormat('id', { style: 'currency', currency: 'IDR'}).format(angka);
    console.log(lokal);
    return lokal;
}

const setTable = async data => {

    Array.from(data, item => {
        const row = tbody.insertRow();
        const keys = Object.keys(item);

        // set id
        row.dataset.id = item.id;
        // Column 1
        const cell_0 = row.insertCell(0);
        cell_0.innerHTML = `<div class="form-check">` +
                                `<input type="checkbox" class="form-check-input" id="row_${item.id}" name="row[]" value="${item.id}">` + 
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
        cell_2.dataset.name = keys[1];
        cell_2.innerText = item[keys[1]];
        cell_2.classList.add('ps-1');
        // Column 4
        const cell_3 = row.insertCell(3);
        cell_3.dataset.name = keys[2];
        cell_3.innerText = intToCurrency(item[keys[2]]);
        cell_3.classList.add('ps-1');
        // Column 5
        const cell_4 = row.insertCell(4);
        cell_4.innerHTML =  `<span class="d-flex flex-nowrap flex-grow-0 align-items-center">` +
                                `<button type="button" class="btn btn-sm btn-info btn-circle p-0 m-0 edit_data" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit font-reset"></i></button>` +
                                `<button type="button" class="btn btn-sm btn-danger btn-circle p-0 m-0 ms-1 delete_data" data-bs-toggle="tooltip" data-bs-title="Delete"><i class="fas fa-trash font-reset"></i></button>` + 
                            `</span>`;
        cell_4.classList.add('ps-1');
    });
}
