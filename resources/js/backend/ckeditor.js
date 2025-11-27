import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

window.initCkeditor = (element, options = {}) => {
    ClassicEditor
        .create(element, options)
        .then(editor => {
            window.editors = window.editors || {};
            window.editors[element.id] = editor;
        })
        .catch(error => {
            console.error(error);
        });
};

window.destroyCkeditor = (id) => {
    if (window.editors && window.editors[id]) {
        window.editors[id].destroy()
            .then(() => {
                delete window.editors[id];
            });
    }
};
