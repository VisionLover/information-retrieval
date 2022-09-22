<!doctype html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- Main Style CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/style.css')}}" >
    <link rel="stylesheet" type="text/css" href="/css/found.css" disabled />
    <link rel="stylesheet" type="text/css" href="/css/notfound.css" disabled />
{{--    <link rel="stylesheet" type="text/css" href="/css/found.css" >--}}
    <title>search</title>
</head>
<body>
<div id="app">
<div class="container c1">
    <div class="row justify-content-center" style="height: 100%">
        <div class="col-md-7">
            <form action="http://127.0.0.1:8000/records" @submit.prevent="submit(1)">
                <h1 class="pq" id="pq">project quest</h1>
                <input type="text" placeholder="عبارت را جستجو کنید" id="input" v-model="mysearch" autocomplete="off" @keyup="suggest()">
                <button class="search" id="search"></button>
                <p class="find" id="find">موردی یافت نشد</p>
            </form>
            <div class="suggest" id="box_suggests">
                <p v-for="sarray in sarrays" @click="close(sarray)" id="suggests"><span>@{{ sarray }}</span></p>
            </div>
        </div>
    </div>
</div>
<div class="container" id="results">
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="item_box">
            <div>
                <ul>
                    <li class="o-listView__item o-listView__item--hasIndicator c-jobListView__item">
                        <div class="o-listView__itemWrap c-jobListView__itemWrap u-clearFix">
                            <div class="o-listView__itemInfo">
                                <h3 class="o-listView__itemTitle c-jobListView__title">
                                    <a class="c-jobListView__titleLink" target="_blank" style="color: black;font-size: 50%">
                                        @{{ count }} فرصت شغلی یافت شد :
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </li>
                    <li class="o-listView__item o-listView__item--hasIndicator c-jobListView__item" v-for="item in items">
                        <div class="o-listView__itemWrap c-jobListView__itemWrap u-clearFix">
                            <div class="o-listView__itemInfo">
                                <h3 class="o-listView__itemTitle c-jobListView__title">
                                    <a class="c-jobListView__titleLink" target="_blank" :href="item.link">
                                        @{{ item.title }}
                                    </a>
                                </h3>
                                <ul class="o-listView__itemComplementInfo c-jobListView__meta">
                                    <li class="c-jobListView__metaItem">
                                        <i class="c-jobListView__metaItemIcon c-icon c-icon--12x12 c-icon--construction"></i>
                                        <span>@{{ item.company }}</span>
                                    </li>
                                    <li class="c-jobListView__metaItem">
                                        <i class="c-jobListView__metaItemIcon c-icon c-icon--12x12 c-icon--place"></i>
                                        <span>@{{ item.city }}</span>
                                    </li>
                                    <li class="c-jobListView__metaItem">
                                        <i class="c-jobListView__metaItemIcon c-icon c-icon--12x12 c-icon--resume"></i>
                                        <span>@{{ item.time }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <div class="pagination justify-content-center">
                        <a href="#" @click="submit(mypagenumber - 1)">&raquo;</a>
                        <a class="options" href="#" :id="pagearray" v-for="pagearray in pagearrays" @click="submit(pagearray)">@{{ pagearray }}</a>
                        <a href="#" @click="submit(mypagenumber + 1)">&laquo;</a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>
