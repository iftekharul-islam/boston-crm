<template>
    <div class="m-form" outlined ref="m-form" :free="free!=null?'true':'no'" :dense="dense" :style="labelStyleSet">
        <input select :type="inputType" :color="color" :value="configValue" readonly @click="itemShow = true; itemData = item;"/>
        <label class="input-label" v-html="chooseLabel"></label>
        <div class="icon-right input-right-icon" v-if="icon">
            <i :class="`mdi ${iconData}`"></i>
        </div>
        <transition name="slide-y">
            <div class="select-list" v-if="itemShow && tabDisable">
                <div class="select-list-search" v-if="searchbox">
                    <input
                        type="text"
                        placeholder="Search"
                        class="select-search"
                        @input="updateSearch($event.target.value)"
                    />
                </div>
                <div class="select-list-item">
                    <transition-group name="list">
                        <template v-if="itemData && itemData.length > 0">
                            <div class="select-item" v-for="(item, it) in itemData" :key="it" @click="chooseItem(item)" :active="checkActive(item, value)">
                                <slot name="item" v-bind:item="item">
                                    <span v-if="object==true">
                                        {{ item[textItem] }}
                                    </span>
                                    <span v-else>
                                        {{ item }}
                                    </span>
                                </slot>
                            </div>
                        </template>
                        <template v-else>
                            <div class="select-item" key="nolist">
                                Sorry, no data found.
                            </div>
                        </template>
                    </transition-group>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: ["label", "icon", "disabled", "color", "type", "item", "search", "label-color", "return-object", "item-text", "item-value", "free", "dense", 
    'min-width', 'max-width', 'width', 'label-dot'],
    data: () => ({
        inputType: "text",
        inputValue: null,
        value: null,
        iconData: null,
        itemData: null,
        itemShow: false,
        searchbox: false,
        labelColors: "var(--whiteColor)",
        object: false,
        textItem: null,
        valueItem: null,
        configValue: null,
        chooseOldReturn: null,
        chooseLabel: null,
        labelStyleSet: null,
        key:null,
        tabDisable: true,
    }),
    model: {
        prop: "modelValue",
        event: "change"
    },
    created() {
        if(this.disabled){
            this.tabDisable = this.disabled;
        }
        this.key = 'input-' + Math.floor(Math.random(100000)*100000).toString();
        this.chooseLabel = this.label ? this.label : null;
        this.labelStyleSet = `${this.minWidth ? 'min-width:'+this.minWidth+'px;' : ''} ${this.maxWidth ? 'max-width:'+this.maxWidth+'px;' : ''} ${this.width ? 'width:'+this.width+'px;' : ''}`;
        if (this.type || this.type != null) {
            this.inputType = this.type;
        } else {
            this.inputType = "text";
        }
        if (this.icon || this.icon != null) {
            this.iconData = this.icon;
        }
        this.itemData = this.item;
        this.value = this.$attrs.modelValue;
        if (this.search != null) {
            this.searchbox = true;
        } else {
            this.searchbox = false;
        }
        if (this.labelColor || this.labelColor != null) {
            this.labelColors = this.labelColor;
        }
        if(this.returnObject !== undefined){
            this.object = true;
            this.textItem = this.itemText;
            if(this.itemValue){
                this.valueItem = this.itemValue;
            }
        }
    },
    methods: {
        checkActive(item, value){
            if(this.object == true){
                if(value == item[this.textItem]){
                    return true;
                }else{
                    return false;
                }
            }else{
                if(item == value){
                    return true;
                }else{
                    return false;
                }
            }
        },
        updateLabel() {
            let ref = this.$refs["m-form"];
            let mForm = $(ref);
            let ele = mForm.find("input")[0];
            let parent = $(ele).parent().find("label.input-label")[0];
            let rightIcon = mForm.has(".icon-right");
            if (rightIcon.length) {
                ele.style.paddingRight = this.$store.state.init.input.paddingRight;
            }
            if (this.value != null && this.value.toString().length > 0) {
                this.showValue();
                parent.style.top = "-8px";
                parent.style.fontSize = "10px";
            } else {
                parent.style.top = "10px";
                parent.style.fontSize = "16px";
            }
        },
        chooseItem(item) {
            let returnItem = item;
            if(this.object == true){
                this.value = item[this.textItem];
                if(this.valueItem != null){
                    returnItem = item[this.valueItem];
                }
            }else{
                this.value = item;
            }
            this.configValue = this.value;
            this.$emit("change", returnItem);
            this.itemShow = false;
            this.updateLabel();
        },
        updateSearch(value) {
            let newArray = [];
            let search = value.toUpperCase();
            if(this.object == true){
                newArray = this.item.filter(e => {
                    let searchValue = e[this.itemText].toUpperCase();
                    return searchValue.includes(search);
                });
            }else{
                newArray = this.item.filter(e => {
                    let searchValue = e.toUpperCase();
                    return searchValue.includes(search);
                });
            }
            this.itemData = newArray;
        },
        showValue(){
            if(typeof this.value === 'object'){
                if(this.value && this.value[this.textItem]){
                    this.configValue = this.value[this.textItem];
                }else{
                    this.configValue = this.value;
                }
            } else{
                if(this.itemValue){
                    let active = this.item.find(ele => {
                        return ele[this.itemValue] == this.value;
                    });
                    if(active){
                        this.configValue = active[this.itemText];
                    }else{
                        this.configValue = this.value;
                    }
                }else{
                    this.configValue = this.value;
                }
            }
        }
    },
    mounted() {
        this.updateLabel();
        this.$bus.$on('clickHole', e => {
            let target = $(this.$refs['m-form']);
            if(!target.is(e.target) && !target.has(e.target).length){
                this.itemShow = false;
            }
        });
        // this.globalParent();
    },
    watch: {
        $attrs: {
            handler(val) {
                this.value = val.modelValue;
                this.showValue();
                this.updateLabel();
            },
            deep: true
        },
        $props: {
            handler(val){
                if(val.label){
                    this.chooseLabel = val.label ? val.label : null;
                }
                if(val.disabled){
                    this.tabDisable = val.disabled;
                }
            },
            deep: true,
        }
    }
};
</script>

<style lang="css" scoped></style>