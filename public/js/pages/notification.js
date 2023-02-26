import { Autocomplete } from '../../vendor/autocomplete/autocomplete.js';
'use strict';

const editor = new Quill('textarea[name="notice-content"]', {
    theme: 'snow'
});

const autocomplete = new Autocomplete(document.querySelector('input[name="notice-project_text"]'), {
    threshold: 1,
    onSelectItem: e => {
        document.querySelector('input[name="notice-project"]').value = e.value;
    }
});

const getProjects = async () => {

    try
    {
        const f = await fetch(`${window.location.href}/projects`);
        const j = await f.json();
        const _map = j.map(x => ({'value': x.id, 'label': x.project_name}));
        autocomplete.setData(_map);
    }
    catch(err)
    {

    }
}

(async () => {
    await getProjects();
})();
