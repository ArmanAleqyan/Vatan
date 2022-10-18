let reg = document.querySelectorAll('.modal_click');

reg.forEach(e => {
    e.addEventListener('click', function (event) {
        event.preventDefault();
        let button = document.querySelector(`#${event.srcElement.attributes['data-id'].value}`);
        button.classList.add('active');
        let body = document.querySelector('body');
        body.classList.add('active_body');
    });
});

let closeButton = document.querySelectorAll('.close_modal');

closeButton.forEach(e => {
    e.addEventListener('click', function (event) {
        event['path'][3].classList.remove('active')
        let body = document.querySelector('body');
        body.classList.remove('active_body');
    });
});

let lang = Object.entries(document.querySelector('#lang').children);

let st = document.querySelector('#lang');
let ed = document.querySelector('.selected_leng');

let elemneted = option__(st.value, lang);

ed.innerHTML += (`<div class="leng_style d-flex align-items-center">
                                        <div class="leng_icon">
                                            <img src="${elemneted.dataset.icon}" alt="">
                                        </div>
                                        <div class="leng_title">
                                            ${elemneted.innerText}
                                        </div>
                                    </div>`);


let language_select = document.querySelector('.language_select');

lang.forEach((option) => {
    // icon - option[1].dataset.icon
    // Title - option[1].innerText
    // value - option[1].value

    language_select.innerHTML += (`<div class="leng_style click_change d-flex align-items-center" data-value="${option[1].value}">
                                        <div class="leng_icon">
                                            <img src="${option[1].dataset.icon}" alt="">
                                        </div>
                                        <div class="leng_title">
                                            ${option[1].innerText}
                                        </div>
                                    </div>`);
});

function option__(value, object) {
    let leng = null;
    object.forEach(e => {
        if (value == e[1].value) {
            leng = e[1];
        }
    });

    return leng;
}

let click_chan = document.querySelectorAll('.click_change');

click_chan.forEach(e => {
    e.addEventListener('click', function (ev) {
        document.querySelectorAll('#lang > option').forEach(et => {
            et.removeAttribute('selected');
            if (e.attributes['data-value'].value == et.value) {
                et.setAttribute('selected', 'selected');
            }
        });
        st.value = e.attributes['data-value'].value;
        let obj = option__(e.attributes['data-value'].value, lang);
        ed.innerHTML = (`<div class="leng_style click_change d-flex align-items-center"  data-value="${obj.value}">
                                        <div class="leng_icon">
                                            <img src="${obj.dataset.icon}" alt="">
                                        </div>
                                        <div class="leng_title">
                                            ${obj.innerText}
                                        </div>
                                    </div>`);
        document.querySelector('.language_select').classList.remove('active');
    });
})

document.querySelector('.selected_leng ').addEventListener('click', function (ev) {
    document.querySelector('.language_select').classList.add('active');
});

let click_change_form = document.querySelectorAll('.click_change_form');

click_change_form.forEach(e => {

    e.addEventListener('click', function (et) {
        let element = et.target.parentElement.parentElement.querySelectorAll(':scope > form')[0].querySelectorAll('.change_input_email_and_phone')[0];
        let event = et.target.parentElement.querySelectorAll('.click_change_form');
        let desc = et.target.parentElement.parentElement.querySelectorAll('.modal_desc');
        try {
            desc.forEach(e => {
                e.classList.remove('active');
            })
        } catch {
        }

        if (e.attributes['data-info'].value == 'phone') {
            try {
                desc[0].classList.add('active');
            } catch {
            }
            element.removeAttribute('type');
            element.setAttribute('type', 'number');
            element.removeAttribute('name');
            element.setAttribute('name', 'phone');
            element.removeAttribute('placeholder');
            element.setAttribute('placeholder', e.attributes['data-placeholder'].value);
        } else if (e.attributes['data-info'].value == 'email') {
            try {
                desc[1].classList.add('active');
            } catch {
            }
            element.removeAttribute('type');
            element.setAttribute('type', 'email');
            element.removeAttribute('name');
            element.setAttribute('name', 'email');
            element.removeAttribute('placeholder');
            element.setAttribute('placeholder', e.attributes['data-placeholder'].value);
        }
        event.forEach(e => {
            e.classList.remove('active');
        })
        e.classList.add('active');
    });
});

let password_ = document.querySelectorAll('.view_password');

password_.forEach(e => {
    e.addEventListener('click', function () {
        if (e.parentElement.children[1].getAttribute('type') == 'password') {
            e.parentElement.children[1].removeAttribute('type');
            e.parentElement.children[1].setAttribute('type', 'text');
            e.classList.add('active__');
        } else if (e.parentElement.children[1].getAttribute('type') == 'text') {
            e.parentElement.children[1].removeAttribute('type');
            e.parentElement.children[1].setAttribute('type', 'password');
            e.classList.remove('active__');
        }
    });
});

$(document).ready(function () {

    var foopicker = new FooPicker({
        id: 'datepicker',
        dateFormat: 'MM/dd/yyyy'
    });
});

// $(document).on("submit", ".popup", function (event) {
//     event.preventDefault();
//
//     var token = $('meta[name="csrf-token"]').attr('content');
//
//     var number = $('input[name="number"]', this);
//     var number_val = number.val();
//
//
//     $.ajax({
//         url: "https://vatan.justcode.am/forgot-password",
//         type: 'POST',
//         data: {number},
//         cache: false,
//         processData: false,
//         contentType: false,
//         success: function (data) {
//             console.log(data);
//         },
//         error: function (error) {
//             console.log(error)
//         }
//     });
// })
