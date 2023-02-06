'use strict';

const table = document.getElementById('tbl-main');
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
   
    var dateF

    searchForm.addEventListener('submit', e => {

    });

    
})();

// Set Table
const setTable = async data => {
    tbody.innerHTML = null;
    
    document.getElementById('loading-table').classList.remove('d-none');

    Array.from(data.data, (item, idx) => {
        const row = tbody.insertRow(idx);

    });

    await setPagination(data);
    document.getElementById('loading-table').classList.add('d-none');
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


