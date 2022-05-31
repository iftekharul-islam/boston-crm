import Vue from "vue";

Vue.mixin({
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
        getLocationInfo(input, mapData) {

            return {
                mapData: mapData,
                location: addressData
            }
        },
    }
});