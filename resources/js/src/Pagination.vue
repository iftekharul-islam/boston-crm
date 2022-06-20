<template>
    <div class="paginate-box" :align="align" v-if="totalPage > 1">
        <button class="page-item" title="Previous" :disabled="activePage == 1" @click="choosePage(activePage-1)">
            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.50929 1.21729C4.79348 0.942569 4.79348 0.487863 4.51876 0.213144C4.23457 -0.071048 3.78934 -0.071048 3.51462 0.213144L0.20852 3.5003C0.0758975 3.63292 0.000112844 3.81291 0.000112835 4.00237C0.000112827 4.19183 0.0758975 4.37182 0.20852 4.50444L3.51462 7.79159C3.64724 7.93369 3.82723 8 4.00722 8C4.19668 8 4.37667 7.93369 4.51876 7.79159C4.79348 7.5074 4.79348 7.06217 4.50929 6.78745L1.71474 4.00237L4.50929 1.21729Z" fill="#7E829B"/>
            </svg>
         </button>
        <button class="page-item" :class="`${activePage == 1 ?  'active-page' : ''}`" title="Page 1" @click="choosePage(1)">1</button>
        <span v-for="page, ik in allPage" :key="ik">
            <button v-if="page > 1" :title="`Page ${page}`" :class="`${activePage == page ?  'active-page' : ''}`" @click="choosePage(page)">{{ page }}</button>
        </span>
        <button class="page-item" v-if="totalPage > 1" :class="`${activePage == totalPage ?  'active-page' : ''}`" :title="`Page ${totalPage}`" @click="choosePage(totalPage)">{{ totalPage }}</button>
        <button class="page-item" title="Next" :disabled="activePage == totalPage" @click="choosePage(activePage+1)"> 
           <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.215319 6.78271C-0.0688726 7.05743 -0.0688719 7.51214 0.205847 7.78686C0.490039 8.07105 0.935272 8.07105 1.20999 7.78686L4.51609 4.4997C4.64871 4.36708 4.7245 4.18709 4.7245 3.99763C4.7245 3.80817 4.64871 3.62818 4.51609 3.49556L1.20999 0.208407C1.07737 0.0663113 0.89738 -3.91831e-08 0.717392 -3.13155e-08C0.527931 -2.30339e-08 0.347942 0.0663113 0.205847 0.208407C-0.0688722 0.492599 -0.0688729 0.937834 0.215319 1.21255L3.00987 3.99763L0.215319 6.78271Z" fill="#7E829B"/>
           </svg>
         </button>
    </div>
</template>
<script>
export default {
    name: 'm-paginate',
    props: ['total-page', 'align', 'active', 'show'],
    data: () => ({
        activePage: 1,
        showing: true,
        lastPage: 0,
        firstObject: [],
        secondObject: [],
        devidedPage:0,
        allPage: 1,
    }),
    model: {
        event: "change",
    },
    created(){
        if(this.active){
            this.activePage = this.active;
        }
        if(this.show){
            this.showing = this.show;
        }
        this.loadPageInfo();
    },
    methods: {
        choosePage(page){
            this.activePage = page;
            this.$emit('loadPage', page);
        },
        loadPageInfo(val = null){
            let getLastPage = this.totalPage;
            if(val != null){
                this.showing = val.show;
                getLastPage = val.totalPage;
            }
            this.allPage = parseInt(getLastPage)-1;
        }
    },
    watch: {
        page: function(newVal, oldval){
            this.$emit('loadPage', newVal);
        },
        $props: {
            handler(val){
                this.loadPageInfo(val);
            },
            deep: true
        }
    },
}
</script>

<style scoped>
.paginate-box {
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 20px 0px;
}

.paginate-box[align="center"] {
    text-align: center;
}

.paginate-box[align="right"] {
    text-align: right;
}

.paginate-box .page-item {
    width: 32px;
    min-width: 32px;
    height: 32px;
    border: 1px solid rgba(126, 130, 155, 0.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}
.paginate-box .page-item:last-of-type {
    margin-right: 0;
}

.paginate-box .page-item:hover {
    transition: all 200ms linear;
    background: #2F415E;
    color: #fff;
}
.paginate-box .page-item:hover svg path {
    fill: #fff;
}
.paginate-box .page-item.active-page {
    background: #2F415E;
    color: #fff;
}
.paginate-box .page-item[disabled] {
    opacity: .5;
    cursor: not-allowed;
}
.paginate-box .page-item[disabled]:hover {
    background: transparent;
    color: #000;
}
.paginate-box .page-item[disabled]:hover svg path {
    fill: #2F415E;
}


</style>
