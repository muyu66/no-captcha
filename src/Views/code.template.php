<style>
    .left {
        width: 75px;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        background: #f9f9f9;
        color: #000;
        height: 72px;
    }

    .mid {
        width: 150px;
        font-family: Roboto, helvetica, arial, sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 17px;
        display: table-cell;
        vertical-align: middle;
        cursor: default;
        background: #f9f9f9;
        color: #000;
        text-align: center;
    }

    .right {
        width: 75px;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        cursor: default;
        font-family: Roboto, helvetica, arial, sans-serif;
        font-size: 11px;
        font-weight: 200;
        color: #9b9b9b;
    }

    .box {
        background: #f9f9f9;
        border: 1px solid #d3d3d3;
        color: #000;
        height: 74px;
        width: 300px;
        border-radius: 3px;
        box-shadow: 0 0 4px 1px rgba(0, 0, 0, 0.08);
        display: block;
    }

    .button {
        height: 32px;
        width: 32px;
        background-color: whitesmoke;
        box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.2);
        border: 1px solid #ccc;
    }

    .button:hover {
        box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.6);
    }

    .info_right {
        font-size: 38px;
        font-weight: 400;
        color: darkgreen;
        background-color: transparent;
        border: 0;
    }
</style>


<style>
    .spinner {
        margin: 0 auto;
        width: 32px;
        height: 32px;
        background-color: rgba(0, 0, 0, 0.8);
        -webkit-animation: rotateplane 1.2s infinite ease-in-out;
        animation: rotateplane 1.2s infinite ease-in-out;
    }

    @-webkit-keyframes rotateplane {
        0% {
            -webkit-transform: perspective(120px)
        }
        50% {
            -webkit-transform: perspective(120px) rotateY(180deg)
        }
        100% {
            -webkit-transform: perspective(120px) rotateY(180deg) rotateX(180deg)
        }
    }

    @keyframes rotateplane {
        0% {
            transform: perspective(120px) rotateX(0deg) rotateY(0deg);
            -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg)
        }
        50% {
            transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
            -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg)
        }
        100% {
            transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
            -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
        }
    }
</style>

<div class="box" onclick="generate()">
    <div class="left">
        <button id="check_box" class="button"></button>
        <div class="spinner" id="loading" style="display: none;"></div>
        <button id="check_right" class="info_right" style="display: none;">☑</button>
    </div>
    <div class="mid">
        v-bind:message
    </div>
    <div class="right">
        v-bind:name<br/>
        v-bind:sign
    </div>
</div>

<script>
    function generate() {
        document.getElementById('loading').style.display = '';
        document.getElementById('check_box').style.display = 'none';
        document.getElementById('check_right').style.display = 'none';
        ajax("v-bind:generate", function (data) {
            setTimeout("valid()", data * 1000);
        });
    }

    function valid() {
        ajax("v-bind:valid", function (data) {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('check_box').style.display = 'none';
            document.getElementById('check_right').style.display = '';
        });
    }

    function ajax(url, func) {
        var data = null;
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                func(this.responseText);
            }
        });
        xhr.open("GET", url);
        xhr.send(data);
    }
</script>