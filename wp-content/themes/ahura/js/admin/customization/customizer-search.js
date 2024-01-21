jQuery(document).ready(function ($) {
    let searchFormTemplate = `
        <div id="ah-accordion-section-customizer-search" class="ah-customizer-search-form">
            <h4 class="customizer-search-section accordion-section-title">
                <span class="search-input-label">${ahura_data.texts.search}</span>
                <span class="search-field-wrapper">
                    <input type="text" placeholder="${ahura_data.texts.placeholder}" name="customizer-search-input" autofocus="autofocus" id="ah-customizer-search-input" class="ah-customizer-search-input">
                    <button type="button" class="button ah-clear-search" tabindex="0">${ahura_data.texts.clear}</button>
                </span>
            </h4>
        </div>
        `,
        customizerThemeControlsName = 'customize-theme-controls',
        searchInputSelector = '#ah-customizer-search-input',
        customizerPanels = '';

    let AhuraCustomizerSearchAdmin = {
        init: function () {
            this.bind();

            const controls = $.map(_wpCustomizeSettings.controls, function (control, index) {
                $.map(_wpCustomizeSettings.sections, function (section, index) {
                    if (control.section == section.id) {
                        $.map(_wpCustomizeSettings.panels, function (panel, index) {
                            if ('' == section.panel) {
                                control.panelName = section.title;
                            }

                            if (section.panel == panel.id) {
                                control.sectionName = section.title;
                                control.panel = section.panel;
                                control.panelName = panel.title;
                            }
                        });
                    }
                });

                return [control];
            });

            customizerPanels = document.getElementById(customizerThemeControlsName);

            let customizePanelsParent = $('#' + customizerThemeControlsName);
            customizePanelsParent.after('<div id="ah-search-results"></div>');

            $(document).on('keyup', searchInputSelector, function (event) {
                event.preventDefault();
                let $this = $(searchInputSelector);
                let string = $this.val();

                if (string.length > 0) {
                    AhuraCustomizerSearchAdmin.displayMatches(string, controls);
                } else {
                    AhuraCustomizerSearchAdmin.clearSearch();
                }

            });

            $(document).on('click', '.ah-clear-search', function (e) {
                AhuraCustomizerSearchAdmin.clearSearch();
            });
        },

        expandSection: function (setting) {
            const sectionName = this.getAttribute('data-section');
            const section = wp.customize.section(sectionName);
            AhuraCustomizerSearchAdmin.clearSearch();
            section.expand();
        },

        displayMatches: function (stringToMatch, controls) {
            const matchArray = AhuraCustomizerSearchAdmin.findMatches(stringToMatch, controls);

            if (0 === matchArray.length) return; // Return if empty results.

            html = matchArray.map(function (index, elem) {

                if ('' === index.label) return; // Return if empty results.

                let settingTrail = index.panelName;
                if ("" != index.sectionName) {
                    settingTrail = `${settingTrail} ▸ ${index.sectionName}`;
                }

                const regex = new RegExp(stringToMatch, 'gi');

                const label = index.label.replace(regex, `<span class="hl">${stringToMatch}</span>`);
                settingTrail = settingTrail.replace(regex, `<span class="hl">${stringToMatch}</span>`);

                return `
                    <li id="accordion-section-${index.section}" class="accordion-section control-section control-section-default ah-customizer-search-results" aria-owns="sub-accordion-section-${index.section}" data-section="${index.section}">
                        <h3 class="accordion-section-title" tabindex="0">
                            ${label}
                        </h3>
                        <span class="search-setting-path">${settingTrail}</span>
                    </li>
                `;
            }).join('');

            customizerPanels.classList.add('ah-search-not-found');
            document.getElementById('ah-search-results').innerHTML = `<ul id="ah-customizer-search-results">${html}</ul>`;

            const searchSettings = document.querySelectorAll('#ah-search-results .accordion-section');
            searchSettings.forEach(setting => setting.addEventListener('click', AhuraCustomizerSearchAdmin.expandSection));
        },

        findMatches: function (stringToMatch, controls) {
            return controls.filter(control => {
                if (control.panelName == null) control.panelName = '';
                if (control.sectionName == null) control.sectionName = '';

                const regex = new RegExp(stringToMatch, 'gi');
                return control.label.match(regex) || control.panelName.match(regex) || control.sectionName.match(regex)
            });
        },

        /**
         * Binds admin customize events.
         */
        bind: function () {
            wp.customize.previewer.targetWindow.bind($.proxy(this.showSearchForm, this));
        },

        /**
         * Shows the message that is shown for when a header
         * or footer is already set for this page.
         */
        showSearchForm: function () {
            if ($('#customize-info #ah-accordion-section-customizer-search').length === 0) {
                $('#customize-info .customize-panel-description').after(searchFormTemplate);
            }
        },

        /**
         * Clear Search input and display all the options
         */
        clearSearch: function () {
            const panels = document.getElementById(customizerThemeControlsName);
            panels.classList.remove('ah-search-not-found');
            document.getElementById('ah-search-results').innerHTML = '';
            document.getElementById('ah-customizer-search-input').value = '';

            $(searchInputSelector).focus();
        }
    };

    AhuraCustomizerSearchAdmin.init();
});