/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        mysearch:"",
        count:"",
        paginate:"",
        mypagenumber:"",
        pagearrays: [1,2,3,4,5,6,7,8,9],
        items: [],
        sarrays: [],
        executed: false
    },
    mounted(){
    },

    methods: {

        submit: function(pagenumber) {
            this.mypagenumber = pagenumber;
            if (pagenumber>5){
                this.pagearrays = [];
                var y = pagenumber - 4;
                var z = y + 10;
                for(y;y<z;y++){
                    this.pagearrays.push(y);
                }
            }
            else {
                this.pagearrays = [];
                var y = 1;
                for(y;y<10;y++){
                    this.pagearrays.push(y);
                }
            }
            var a = document.getElementsByClassName('options');
            for (var i = 0; i < a.length; i++) {
                a[i].classList.remove('active')
            }
            setTimeout(function(){document.getElementById(pagenumber).classList.add('active');},1000);
            this.sarrays = [];
            axios.post('http://127.0.0.1:8000/records', {
                mysearch: this.mysearch,
                pagenumber: pagenumber
            })
            .then(response => {
                var length = response.data[0].length;
                this.count = response.data[5];
                this.paginate = response.data[6];
                if (length == 0){
                    if(this.mysearch != "" && this.executed == false){
                    $("#pq").fadeOut();
                    $('link[href="/css/notfound.css"]')[0].disabled = false;
                    setTimeout(function(){ document.getElementById("search").style.top = "-50px" }, 1500);
                    setTimeout(function(){ $("#find").fadeIn(700) }, 2000);
                    setTimeout(function(){ $("#find").fadeOut(700) }, 2500);
                    setTimeout(function(){ document.getElementById("search").style.top = "45px" }, 3500);
                    setTimeout(function(){ $('link[href="/css/notfound.css"]')[0].disabled=true; }, 4800);
                    setTimeout(function(){ $("#pq").fadeIn(1000); }, 4800);
                    }
                    if (this.mysearch != "" && this.executed == true) {
                        this.items = [];
                        this.items.push({'title': "به‌نظر می‌رسد نتیجه خوبی مطابق با جستجوی شما وجود ندارد"});
                        this.items[0]['company'] = "نکته: سعی کنید از کلمه‌هایی استفاده کنید که ممکن است در صفحه‌ای که جستجو می‌کنید وجود داشته باشد. مثلاً به‌جای «دستور پخت کیک» از «نحوه درست کردن کیک» استفاده کنید.";
                    }
                }
                else {
                    if (this.mysearch != "" && this.executed == false) {
                        this.executed = true;
                        $("#pq").fadeOut();
                        $('link[href="/css/found.css"]')[0].disabled = false;
                        setTimeout(function () {
                            document.getElementById("search").style.bottom = "85%";
                        }, 1500);
                        setTimeout(function () {
                            document.getElementById("input").style.bottom = "85%"
                        }, 1700);
                        setTimeout(function () {
                            $('link[href="/css/found.css"]')[0].disabled = true;
                        }, 2700);
                        setTimeout(function () {
                            $("#results").fadeIn(1000);
                        }, 3000);
                        for (var i = 0; i < length; i++) {
                            this.items.push({'title': response.data[0][i]});
                            this.items[i]['link'] = response.data[1][i];
                            this.items[i]['city'] = response.data[2][i];
                            this.items[i]['company'] = response.data[3][i];
                            this.items[i]['time'] = response.data[4][i];
                        }
                    }
                    if (this.mysearch != "" && this.executed == true) {
                        this.items = [];
                        for (var i = 0; i < length; i++) {
                            this.items.push({'title': response.data[0][i]});
                            this.items[i]['link'] = response.data[1][i];
                            this.items[i]['city'] = response.data[2][i];
                            this.items[i]['company'] = response.data[3][i];
                            this.items[i]['time'] = response.data[4][i];
                        }
                    }
                }
            });
        },

        suggest:function (e) {
            axios.post('http://127.0.0.1:8000/suggest', {
                suggest: document.getElementById("input").value
            })
            .then(response => {
                var input = document.getElementById("input").value;
                if (input == "" || this.executed == true){
                    this.sarrays = []
                }
                else {
                    this.sarrays = response.data;
                }
            })
        },

        close:function (text) {
            $('#input').val(text);
            this.sarrays = [];
            this.mysearch = text
        }

    },

});


