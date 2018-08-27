export default form => {
    let field, l, s = [];

    if (typeof form == 'object' && form.nodeName == "FORM") {
        const count = form.elements.length;

        for (let i=0; i < count; i++) {
            field = form.elements[i];

            if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                if (field.type == 'select-multiple') {
                    l = form.elements[i].options.length;
                    for (var j=0; j<l; j++) {
                        if(field.options[j].selected)
                            s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[j].value);
                    }
                } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
                    s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value);
                }
            }
        }
    }

    return s.join('&').replace(/%20/g, '+');
}
