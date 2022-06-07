import Vue from "vue";

const ConfirmDialogue = () =>
    import ( /* webpackChunkName: "ConfirmDialogue" */ "../src/ConfirmDialogue");

Vue.mixin({
    components: {
        "confirm-dialog": ConfirmDialogue
    },
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
    }
});