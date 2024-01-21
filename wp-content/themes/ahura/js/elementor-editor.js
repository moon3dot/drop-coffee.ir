const ahuraGetClipboardText = function (){
    if (!navigator.clipboard) {
        console.error('Clipboard Not Supported.');
        return;
    }

    return new Promise((resolve, reject) => {
        navigator.clipboard.readText()
            .then(text => {
                resolve(text);
            })
            .catch(err => {
                reject(false);
            });
    });
}

const ahuraValidJson = function (str){
    try {
        JSON.parse(str);
        return true;
    } catch (error) {
        return false;
    }
}

const ahuraGenerateElementID = function (length = 12){
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    const idArray = new Uint8Array(length);
    const cryptoObj = window.crypto || window.msCrypto;

    if (!cryptoObj) {
        throw new Error("Crypto API is not available in this environment.");
    }

    cryptoObj.getRandomValues(idArray);

    let id = "";
    for (let i = 0; i < length; i++) {
        id += charset[idArray[i] % charset.length];
    }

    return id;
}

window.addEventListener( 'elementor/init', () => {
    let ahuraPrepareMenuItem = function (e, t){
        let n = _.findIndex(e, function (e) {
            return "clipboard" === e.name;
        });
        return (
            e.splice(n + 1, 0, {
                name: 'ahura-links-group',
                actions: [
                    {
                        name: 'ahura-elementor-paste-element',
                        icon: 'eicon-import-kit',
                        title: ahura_editor_data.paste_title,
                        isEnabled: () => true,
                        callback: () => {
                            let elType = t.model.attributes.elType;

                            ahuraGetClipboardText().then(widgetJson => {
                                if(widgetJson && ahuraValidJson(widgetJson)){
                                    let jsonData = JSON.parse(widgetJson),
                                        elementID = ahuraGenerateElementID();

                                    if(!jsonData.hasOwnProperty('elements')){
                                        return false;
                                    }

                                    let container = null,
                                        options = {index: 0},
                                        elementData = jsonData.elements[0];

                                    elementData.id = elementID || elementData.id;

                                    if(elementData.hasOwnProperty('settings')){
                                        elementData.settings = {};
                                    }

                                    if(elType === 'widget'){
                                        container = t.getContainer().parent;
                                        options.index = t.getOption("_index") + 1;
                                    } else if(elType === 'column'){
                                        container = t.getContainer();
                                        options.index = t.getOption("_index");
                                    } else if(elType === 'section' || elType === 'container'){
                                        container = t.children.findByIndex(0).getContainer();
                                    }

                                    if(container){
                                        $e.run("document/elements/create", { model: elementData, container: container, options: options });
                                    }
                                }
                            }).catch(error => {console.error(error)});
                        },
                    },
                ],
            }), e
        );
    }

    elementor.hooks.addFilter("elements/container/contextMenuGroups", function (e, t) {
        return ahuraPrepareMenuItem(e, t);
    });
    elementor.hooks.addFilter("elements/section/contextMenuGroups", function (e, t) {
        return ahuraPrepareMenuItem(e, t);
    });
    elementor.hooks.addFilter("elements/column/contextMenuGroups", function (e, t) {
        return ahuraPrepareMenuItem(e, t);
    });
    elementor.hooks.addFilter("elements/widget/contextMenuGroups", function (e, t) {
        return ahuraPrepareMenuItem(e, t);
    });
});