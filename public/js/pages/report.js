'use strict';

const table = document.getElementById('tbl-main');
const thead = table.tHead;
const tbody = table.tBodies[0];
const searchForm = document.forms['form-search'];
const dateFrom = flatpickr(document.querySelector('input[name="periode_from"]'), { defaultDate: Date.now() });
const dateTo = flatpickr(document.querySelector('input[name="periode_to"]'), { defaultDate: Date.now() });
let fetchUrl = `${window.location.href}/get`;

// INIT
const getData =  async (url, opt={}) => {
    try
    {
        const f = await fetch(url, opt);
        const j = await f.json();

        return j;
    }
    catch(err)
    {
        console.log(err);
    }
} 

(async () => {
    searchForm.addEventListener('submit', async e => await filterData(e));
    searchForm.addEventListener('reset', e => resetTable());

    document.getElementById('to_pdf').addEventListener('click', e => generateReport(e, 'pdf'));

})();

// Set Table
const setTable = async data => {
    document.querySelector('#download-row').classList.remove('d-none');
    thead.innerHTML = null;
    tbody.innerHTML = null;
    // get active links
    let currentLink = data.links.find(x => x.active === true);
    let currentQueryString = new URLSearchParams(currentLink.url.split('?')[1]);
    let filterType = Object.fromEntries(currentQueryString.entries()).filter_type;
    console.log(filterType);
    //set thead
    thead.classList.add('bg-primary', 'text-white');

    const hRow = thead.insertRow(0);
    const h0 = document.createElement('th');
    const h1 = document.createElement('th');
    const h2 = document.createElement('th');
    const h3 = document.createElement('th');
    // thead 
    h0.innerText = 'No';
    h0.classList.add('me-2');
    hRow.appendChild(h0);
   switch(filterType)
   {
        case 'product':
            h1.innerText = 'Product ID';
            h1.dataset.name = 'product_id';
            h1.classList.add('d-none');
            hRow.appendChild(h1);
            // h2
            h2.innerText = 'Nama Produk/Layanan';
            h2.dataset.name = 'product_name';
            hRow.appendChild(h2);
            // h3
            h3.innerText = 'Total';
            h3.dataset.name = 'product_value';
            hRow.appendChild(h3);
            break;
        case 'customer':
            h1.innerText = 'Customer ID';
            h1.dataset.head = 'customer_id';
            h1.classList.add('d-none');
            hRow.appendChild(h1);
            // h2
            h2.innerText = 'Nama Pelanggan';
            h2.dataset.head = 'customer_name';
            hRow.appendChild(h2);
            // h3
            h3.innerText = 'Total';
            h3.dataset.head = 'customer_value';
            hRow.appendChild(h3);
            break;
   }

    
    // set tbody
    if(data.data.length > 0)
    {
        Array.from(data.data, (item, idx) => {
            const row = tbody.insertRow(idx);
    
            const cell_0 = row.insertCell(0);
            const cell_1 = row.insertCell(1);
            const cell_2 = row.insertCell(2);
            const cell_3 = row.insertCell(3);
            
            cell_0.innerText = idx + 1;
            cell_0.classList.add('me-2');
            // cell 1
            cell_1.innerText = item.element_id;
            cell_1.dataset.name = 'element_id';
            cell_1.classList.add('d-none');
            // cell 2
            cell_2.innerText = item.element_name.replaceAll('"', '');
            cell_2.dataset.name = 'element_name';
            cell_2.classList.add('me-1');
            // cell 3
            cell_3.innerText = intToCurrency(item.element_value);
            cell_3.dataset.name = 'element_value';
            cell_3.classList.add('me-1');
    
        });
    }
    await setPagination(data);
    
}
// reset Table
const resetTable = () => {
    thead.innerHTML = null;
    tbody.innerHTML = null;
    document.querySelector('#download-row').classList.add('d-none');
}

// Set Paging
const setPagination = async data => {
    var pageNo = document.getElementById('page_no'),
        totalPage = document.getElementById('total_pages');

    // Current Page
    pageNo.innerText = data.current_page;
    // Total Page
    totalPage.innerText = data.last_page;
}

// Filter Data
const filterData = async e => {
    e.preventDefault();

    const obj = Object.fromEntries((new FormData(e.target)).entries());
    const param = new URLSearchParams(obj);
    
    // ajax
    try
    {
        document.getElementById('loading-table').classList.remove('d-none');

        fetchUrl = `${window.location.href}/get?` + param.toString();
        let data = await getData(fetchUrl);
        await setTable(data);

        document.getElementById('loading-table').classList.add('d-none');
    }
    catch(err)
    {

    }
}

// generateReport
const generateReport = async (e, type) => {
    const elem = e.target;

    let params = new URL(fetchUrl).searchParams;
    let obj = {...Object.fromEntries(params.entries()), file_type: type};
    
    try
    {
       elem.href = `${window.location.origin}/reports/generate?` + new URLSearchParams(obj).toString();
       console.log(elem.href);
    }
    catch(err)
    {
        console.log(err);
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

// Format Duit
const intToCurrency = angka => {
    const lokal = new Intl.NumberFormat('id', { style: 'currency', currency: 'IDR'}).format(angka);
    return lokal;
}


