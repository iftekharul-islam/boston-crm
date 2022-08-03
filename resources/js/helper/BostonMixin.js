import Vue from "vue";

const ConfirmDialogue = () =>
    import ( /* webpackChunkName: "ConfirmDialogue" */ "../src/ConfirmDialogue");

const months = {
    full: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
}

Vue.mixin({
    components: {
        "confirm-dialog": ConfirmDialogue
    },
    data: () => ({
        gLoad: false
    }),
    methods: {
        formateDate(date) {
            if (date == null) {
                return '-';
            }
            let d = new Date(Date.parse(date));
            let year = d.getFullYear();
            let dates = d.getDate();
            let fullDate = `${year}-${this.decimalNumber(d.getMonth())}-${this.decimalNumber(dates)}`;
            return fullDate;
        },
        decimalNumber(val) {
            if (val < 10) {
                return "0" + val;
            } else {
                return val;
            }
        },
        copy(data) {
            try {
                var aux = document.createElement("input");
                aux.setAttribute("value", data);
                document.body.appendChild(aux);
                aux.select();
                document.execCommand("copy");
                document.body.removeChild(aux);
                return true;
            } catch (e) {
                return false;
            }
        },
        getLocationInfo(input, mapData) {

            return {
                mapData: mapData,
                location: addressData
            }
        },
        isNumber(val) {
            return !isNaN(val);
        },
        params() {
            let paramsArray = window.location.search.substr(1).split('&');
            let params = [];
            for (let i = 0; i < paramsArray.length; ++i)
            {
                let param = paramsArray[i]
                    .split('=', 2);
                
                if (param.length !== 2)
                    continue;
                
                params[param[0]] = decodeURIComponent(param[1].replace(/\+/g, " "));
            }                    
            return params;
        },
        addParam(key, value){
            key = encodeURIComponent(key); value = encodeURIComponent(value);
            var s = document.location.search;
            var kvp = key+"="+value;
            var r = new RegExp("(&|\\?)"+key+"=[^\&]*");
            s = s.replace(r,"$1"+kvp);
            if(!RegExp.$1) {s += (s.length>0 ? '&' : '?') + kvp;};            
            let path = window.location.href.split('?')[0] + s;            
            history.pushState(null, null, path);
        },
        onlyDateFormate(date) {
            if (date == null) {
                return '-';
            }
            let d = new Date(Date.parse(date));
            let month = d.getMonth();
            let year = d.getFullYear();
            let dates = d.getDate();
        
            let fullDate = `${year}-${month + 1}-${dates}`;
            return fullDate;
        },
        selectText(phone) {
            // let url = "https://vcc-na1.8x8.com/AGUI/make_call.php?phone="+phone;
            let url = "tel://"+phone;
            window.location.href = url;
        },
        textSelect(event) {
            let target = event.target;
            target.select();
        }
    }
});