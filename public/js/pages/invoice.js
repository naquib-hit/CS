import { Autocomplete } from "{{ asset('vendor/autocomplete/autocomplete.js') }}";


// Autocomplete
const customerElement = document.getElementById('customer');
const autocomplete = new Autocomplete(customerElement);
const getCustomer = async () => {
    try
    {
        const f = await fetch(`{{ route('invoices.customers') }}`);
        const j = await f.json();
        const cs = j.map(x => ({'label': x.customer_name, 'value': x.id}));

        autocomplete.setData(cs);
    }
    catch(err)
    {
        console.log(err);
    }
}
// End autompolete

// Items Group
const itemContainer = document.getElementById('items-container'),
      btnAddItem = document.getElementById('add-item');
let elemIndex = 0,
    lastIndex = document.getElementsByClassName('item-name').length - 1;

console.log(lastIndex);

const createItem = () => {
    // new row
    const row = document.createElement('div');
    row.classList.add('row', 'mt-3', 'align-items-baseline');
    // col-left 
    const colLeft = document.createElement('div');
    colLeft.classList.add('col-12', 'col-md-6', 'pe-1');
    // col-middle
    const colMiddle = document.createElement('div');
    colMiddle.classList.add('col-12', 'col-md-4','px-1');
    // col-right
    const colRight = document.createElement('div');
    colRight.classList.add('col-12', 'col-md-2', 'ps-1');
    // input-group-left
    const inputGroupLeft = document.createElement('div');
    inputGroupLeft.classList.add('input-group', 'input-group-outline');
    // input-group-middlw (sengaja beda biar classListNya beda)
    const inputGroupMiddle = document.createElement('div');
    inputGroupMiddle.classList.add('input-group', 'input-group-outline');
    // clear-row 
    const clearRow = document.createElement('button');
    clearRow.type = 'button';
    clearRow.onclick = e => deleteItemRow(e);
    clearRow.classList.add('btn', 'btn-circle', 'btn-danger', 'm-0', 'p-0', 'clear-row');
    // label buat text
    const labelLeft = document.createElement('label');
    labelLeft.classList.add('form-label');
    // label buat number
    const labelMiddle = document.createElement('label');
    labelMiddle.classList.add('form-label');
   // input text
    const inputText = document.createElement('input');
    inputText.type = 'text';
    inputText.classList.add('form-control', 'item-name');
    // input number
    const inputNumber = document.createElement('input');
    inputNumber.type = 'number';
    inputNumber.classList.add('form-control');
    // trash icon
    const faTrash = document.createElement('i');
    faTrash.onclick = () => false;
    faTrash.classList.add('fas', 'fa-trash', 'font-reset');

    // LEFT
    labelLeft.innerHTML = "{{ __('invoice.form.fields.item') }} <span class=\"text-danger\">*</span>";
    inputText.name = "invoice_items["+ (+lastIndex + 1) +"][name]";
    inputText.onfocus = async e => await inputOnFocus(e);
    inputText.onblur = async e => await inputOnFocusOut(e);
    inputText.onkeyup = async e => await inputOnKeyup(e);
    inputGroupLeft.appendChild(labelLeft);
    inputGroupLeft.appendChild(inputText);
    colLeft.appendChild(inputGroupLeft);
    row.appendChild(colLeft);
    // MIDDLE
    //labelMiddle.innerText = '';
    labelMiddle.innerHTML = "{{ __('invoice.form.fields.total') }} <span class=\"text-danger\">*</span>";
    inputNumber.name= "invoice_items["+ (+lastIndex + 1) +"][total]";
    inputNumber.onfocus = async e => await inputOnFocus(e);
    inputNumber.onblur = async e => await inputOnFocusOut(e);
    inputNumber.onkeyup = async e => await inputOnKeyup(e);
    inputNumber.min = 0;
    inputNumber.step = 0.01;
    inputGroupMiddle.appendChild(labelMiddle);
    inputGroupMiddle.appendChild(inputNumber);
    colMiddle.appendChild(inputGroupMiddle);
    row.appendChild(colMiddle);
    // RIGHT
    clearRow.appendChild(faTrash);
    colRight.appendChild(clearRow);
    row.appendChild(colRight);

    return row;
}

// tax group
const taxContainer = document.getElementById('tax-container'),
      btnAddTax = document.getElementById('add-tax');
let elemTaxIndex = 0,
    lastTaxIndex = document.getElementsByClassName('tax-name').length - 1;

const createTax = () => {
    // new row
    const row = document.createElement('div');
    row.classList.add('row', 'mt-3', 'align-items-baseline');
    // col-left 
    const colLeft = document.createElement('div');
    colLeft.classList.add('col-12', 'col-md-6', 'pe-1');
    // col-middle
    const colMiddle = document.createElement('div');
    colMiddle.classList.add('col-12', 'col-md-4','px-1');
    // col-right
    const colRight = document.createElement('div');
    colRight.classList.add('col-12', 'col-md-2', 'ps-1');
    // input-group-left
    const inputGroupLeft = document.createElement('div');
    inputGroupLeft.classList.add('input-group', 'input-group-outline');
    // input-group-middlw (sengaja beda biar classListNya beda)
    const inputGroupMiddle = document.createElement('div');
    inputGroupMiddle.classList.add('input-group', 'input-group-outline');
    // clear-row 
    const clearRow = document.createElement('button');
    clearRow.type = 'button';
    clearRow.onclick = e => deleteItemRow(e);
    clearRow.classList.add('btn', 'btn-circle', 'btn-danger', 'm-0', 'p-0', 'clear-row');
    // label buat text
    const labelLeft = document.createElement('label');
    labelLeft.classList.add('form-label');
    // label buat number
    const labelMiddle = document.createElement('label');
    labelMiddle.classList.add('form-label');
   // input text
    const inputText = document.createElement('input');
    inputText.type = 'text';
    inputText.classList.add('form-control', 'tax-name');
    // input number
    const inputNumber = document.createElement('input');
    inputNumber.type = 'number';
    inputNumber.classList.add('form-control');
    // trash icon
    const faTrash = document.createElement('i');
    faTrash.onclick = () => false;
    faTrash.classList.add('fas', 'fa-trash', 'font-reset');

    // LEFT
    labelLeft.innerHTML = "{{ __('invoice.form.fields.tax') }} <span class=\"text-danger\"></span>";
    inputText.name = "invoice_tax["+ (+lastTaxIndex + 1) +"][name]";
    inputText.onfocus = async e => await inputOnFocus(e);
    inputText.onblur = async e => await inputOnFocusOut(e);
    inputText.onkeyup = async e => await inputOnKeyup(e);
    inputGroupLeft.appendChild(labelLeft);
    inputGroupLeft.appendChild(inputText);
    colLeft.appendChild(inputGroupLeft);
    row.appendChild(colLeft);
    // MIDDLE
    //labelMiddle.innerText = '';
    labelMiddle.innerHTML = "{{ __('invoice.form.fields.total') }} <span class=\"text-danger\"></span>";
    inputNumber.name= "invoice_tax["+ (+lastIndex + 1) +"][total]";
    inputNumber.onfocus = async e => await inputOnFocus(e);
    inputNumber.onblur = async e => await inputOnFocusOut(e);
    inputNumber.onkeyup = async e => await inputOnKeyup(e);
    inputNumber.min = 0;
    inputNumber.step = 0.01;
    inputGroupMiddle.appendChild(labelMiddle);
    inputGroupMiddle.appendChild(inputNumber);
    colMiddle.appendChild(inputGroupMiddle);
    row.appendChild(colMiddle);
    // RIGHT
    clearRow.appendChild(faTrash);
    colRight.appendChild(clearRow);
    row.appendChild(colRight);

    return row;
}
//end tax group

// check if window is changed
const deleteItemRow = e => {
    e = e || window.event;
    e.stopPropagation();
    const row = e.target.parentNode.closest('div.row');
    row.remove();
}

const inputOnFocus = async e => {
    e = e || window.event;
    e.srcElement.parentElement.classList.add('is-filled');
}

const inputOnKeyup = async e => {
    e = e || window.event;
    const el = e.srcElement;
    const parent = el.parentElement;

    if(el.value)
        parent.classList.add('is-filled');
    else
        parent.classList.remove('is-filled');
}

const inputOnFocusOut = async e =>  {
    e = e || window.event;
    console.log(e.target);
    if(!e.target.value)
        e.target.parentElement.classList.remove('is-filled');
}
//observer.disconnect();
// End Items Group

// editor
var editor = new wysihtml5.Editor('editor', {
    toolbar: 'toolbar',
    parserRules:  wysihtml5ParserRules
});
// end editor group

(async () => {
    await getCustomer();

    btnAddItem.addEventListener('click', e => {
        e.preventDefault();
        lastIndex = document.getElementsByClassName('item-name').length - 1;
        itemContainer.appendChild(createItem());
    });

   btnAddTax.addEventListener('click', e => {
        e.preventDefault();
        lastIndex = document.getElementsByClassName('tax-name').length - 1;
        taxContainer.appendChild(createTax());
   });

})();