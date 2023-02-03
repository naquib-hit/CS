'use strict';

const table = document.getElementById('tbl-main');
const tbody = table.tBodies[0];
const searchForm = document.forms['form-search'];
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
    document.getElementById('loading-table').classList.remove('d-none');
    let data = await getData(fetchUrl);
    // INIT Table
    await setTable(data);
    document.getElementById('loading-table').classList.add('d-none');
    // filter data
    searchForm.addEventListener('submit', async e => await filterData(e));

    // paging lef and right
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

// Set Table
const setTable = async data => {
    tbody.innerHTML = null;
    
    Array.from(data.data, (item, idx) => {
        const row = tbody.insertRow(idx);
        // insert cells
        const cell_0 = row.insertCell(0);
        const cell_1 = row.insertCell(1);
        const cell_2 = row.insertCell(2);
        const cell_3 = row.insertCell(3);
        const cell_4 = row.insertCell(4);
        const cell_5 = row.insertCell(5);
        const cell_6 = row.insertCell(6);
        const cell_7 = row.insertCell(7);
        const cell_8 = row.insertCell(8);

        const details = JSON.parse(item.details);
        console.log(details);

        // insert cell 0 - ID
        cell_0.innerHTML = item.id;
        cell_0.classList.add('d-none');
        cell_0.dataset.name = 'id'
        // cell 1 = Transaction No
        cell_1.innerText = item.invoice_no;
        cell_1.dataset.name = 'invoice_no';
        // cell 2 = Customer ID
        cell_2.innerText = details.customers.customer_id;
        cell_2.classList.add('d-none');
        cell_2.dataset.name = 'customer_id';
        // cell 3 = Customer Name
        cell_3.innerText = details.customers.customer_name;
        cell_3.dataset.name = 'customer_name';
        // cell 4 = Create Date
        cell_4.innerText = item.create_date;
        cell_4.dataset.name = 'create_date';
        // cell 5 = Delivery Status
        cell_5.innerHTML = setEmailStatus(item.delivery_status);
        cell_5.dataset.name = 'delivery_status';
        // cell 6 = Send Date
        cell_6.innerText = item.send_date ? item.send_date : '';
        cell_6.dataset.name = 'send_date';
        // cell 7 = Due Date
        cell_7.innerText = item.due_date ? item.due_date : '';
        cell_7.dataset.name = 'due_date';
        
        // cell 8 = Expiration Date
        cell_8.innerHTML = '<button type="button" class="btn btn-info btn-circle p-0 m-0">' +
                                '<i class="fas fa-eye font-reset"></i>' +
                            '</button>';
    });

    await setPagination(data);
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
        fetchUrl = `${window.location.href}/get?` + param.toString();
        let data = await getData(fetchUrl);
        await setTable(data);
    }
    catch(err)
    {

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


