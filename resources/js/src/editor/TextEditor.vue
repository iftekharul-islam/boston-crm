<template>
    <div class="template">
        <div class="m-text-editor" :class="{'invalid' : invalid}" ref="text-editor" :new-key="ucKey">
            <div class="m-text-editor-header" :style="`${headerBg != null ? 'background: '+headerBg+' !important;' : '' }`">
                <button @click="setCommand('copy')">
                    <!-- <i class="mdi mdi-content-copy"></i> -->
                    <img src="/svg/Copy.svg" alt="">
                </button>
                <button @click="setCommand('bold')">
                    <!-- <i class="mdi mdi-format-bold"></i> -->
                    <img src="/svg/text-bold.svg" alt="">
                </button>
                <button @click="setCommand('italic')">
                    <!-- <i class="mdi mdi-format-italic"></i> -->
                    <img src="/svg/italic.svg" alt="">
                </button>
                <button @click="setCommand('justifyLeft')">
                    <!-- <i class="mdi mdi-format-align-left"></i> -->
                    <img src="/svg/textalign-left.svg" alt="">
                </button>
                <button @click="setCommand('justifyCenter')">
                    <!-- <i class="mdi mdi-format-align-center"></i> -->
                    <img src="/svg/textalign-center.svg" alt="">
                </button>
                <!-- <button @click="setCommand('justifyRight')">
                    <i class="mdi mdi-format-align-right"></i>
                </button> -->
                <!-- <button @click="setCommand('justifyFull')">
                    <img src="/svg/justifycenter.svg" alt="">
                </button> -->
                <button @click="setCommand('insertOrderedList')">
                    <img src="/svg/orderedList.svg" alt="">
                </button>
                <button @click="setCommand('insertunorderedlist')">
                    <img src="/svg/Bullete-list.svg" alt="" class="bulletList">
                </button>
                <button @click="setCommand('redo')">
                    <img src="/svg/redo.svg" alt="">
                </button>
                <button @click="setCommand('undo')">
                    <img src="/svg/undo.svg" alt="">
                </button>
                <!-- <button @click="setCommand('insertHorizontalRule')">
                    <i class="mdi mdi-format-vertical-align-center"></i>
                </button> -->
                <!-- <button @click="setCommand('paste', false, '')">
                    Paste
                </button> -->
                <!-- <button @click="setCommand('uppercase')">
                    <i class="mdi mdi-format-vertical-align-top"></i>
                </button>
                <button @click="setCommand('lowercase')">
                    <i class="mdi mdi-format-vertical-align-bottom"></i>
                </button>
                <button @click="setCommand('indent')">
                    <i class="mdi mdi-format-indent-increase"></i>
                </button>
                <button @click="setCommand('outdent')">
                    <i class="mdi mdi-format-indent-increase"></i>
                </button>
                <button @click="showHtml">
                    <i class="mdi mdi-code-tags"></i>
                </button> -->
            </div>
            <div class="m-text-editor-body" @input="getValue($event)" @change="getValue($event)" :placeholder="placeholder ? placeholder : 'Enter content...'" :contenteditable="!disabled" ref="editor" :style="`${ editorStyle }`" v-html="value"></div>
        </div>
        <div class="invalid-message" v-if="invalidMessage">
            <slot>
                {{ invalidMessage }}
            </slot>
        </div>
    </div>
</template>

<script>
import colors from './color';
export default {
    name: 'text-editr-urcv',
    props: ['uc-key', 'update', 'click-type', 'disabled', 'header-bg', 'invalid', 'invalid-message', 'min-height', 'max-height', 'placeholder', 'return-on'],
    data: () => ({
        edit: true,
        firstTry: 0,
        showHtmlStatus: false,
        htmlcode: null,
        returnWhen: "click",
        htmlcode2: null,
        getColor: colors,
        colorType: "Text Color",
        value: null,
        getClickType: 2,
        setMinHeight: null,
        setMaxHeight: null,
        editorStyle: null,
        selectedValue: [],
        editorPrefix: 'urcv-editor_'
    }),
    model: {
        prop: 'modelValue',
        event: 'input',
    },
    created(){
        if(this.clickType){
            if(this.clickType == 1){
                this.getClickType = 1;
            }else{
                this.getClickType = 2;
            }
        }

        if (this.$props.update !== undefined) {
            this.firstTry = 1;
        }

        if(this.returnOn && this.returnOn == "text"){
            this.returnWhen = "text";
        }else{
            this.returnWhen = "click";
        }

        this.value = this.$attrs.modelValue;

        if(this.minHeight != null){
            this.setMinHeight = 'min-height: ' + this.minHeight + 'px!important;';
        }
        if(this.maxHeight != null){
            this.setMaxHeight = 'max-height: ' + this.maxHeight + 'px!important; overflow: auto;';
        }

        this.editorStyle = this.setMinHeight + this.setMaxHeight;
    },
    mounted(){
        $(document).on("click", ".card-box button", function(e){
            let cardItem = $(this).parent().find('.box-item');
            if(cardItem.is(':visible')){
                cardItem.slideUp(100);
            }else{
                cardItem.slideDown(100);
            }
        });
        this.returnValueId();
    },
    methods: {
        setCommand(command, ui=true, value = null){
            let select = window.getSelection().toString();
            if(command == 'uppercase'){
                let newStyle = `<span style="text-transform:uppercase">${select}</span>`;
                document.execCommand('insertHtml', true, newStyle);
            }else if(command == 'lowercase'){
                let newStyle = `<span style="text-transform:lowercase">${select}</span>`;
                document.execCommand('insertHtml', true, newStyle);
            } else if(command == "insertText") {
                document.execCommand('insertText', false, value);
            }else{
                document.execCommand(command, ui, value);
            }
        },
        showHtml(){
            let editor = this.$refs.editor;
            if(this.showHtmlStatus == false){
                this.htmlcode = editor.innerHTML;
                this.showHtmlStatus = true;
                $(editor).text(this.htmlcode);
                $(editor).css({
                    background: "#3e3c3c",
                    color: "#e8e8e8",
                });
            }else{
                this.showHtmlStatus = false;
                this.htmlcode = $(editor).text();
                $(editor).html(this.htmlcode);
                $(editor).css({
                    background: "#fff",
                    color: "#1f2f3f",
                });
            }
        },
        chooseColor(color){
            let type = this.colorType;
            let select = window.getSelection().toString();
            let newStyle = null;
            if(type == "Background"){
                newStyle = `<span style="background-color:${color}">${select}</span>`;
            }else{
                newStyle = `<span style="color:${color}">${select}</span>`;
            }
            document.execCommand('backColor', false, color);
            document.execCommand('foreColor', false, color);
        },


        addValue(res){
            let id = this.editorPrefix + res.id;
            let key = res.key;
            if(key != this.ucKey){
                // console.error("Urcv editor key is invalid or mismatch");
                return;
            }
            let value = res.value;
            let ref = this.$refs.editor;
            let target = $(ref).find("." + id);
            let newValue = `
                <ul class="${id} attr-sections" data-id="${res.id}">
                    <li>${value}</li>
                </ul>
            `;
            if(res.tag){
                newValue = `<div class="${id} attr-sections" data-id="${res.id}">
                    <span>${value}</span>
                </div>`;
            }
            if(target.length){
                if(res.tag){
                    $(target).find("span")[0].innerHTML = value;
                }else{
                    $(target).find('li')[0].innerHTML = value;
                }
            }else{
                $(ref).append(newValue);
            }
            this.getValue($(ref).html(), true);
        },
        removeValue(res){
            let id = this.editorPrefix + res.id;
            let key = res.key;
            if(key != this.ucKey){
                // console.error("Urcv editor key is invalid or mismatch");
                return;
            }
            let ref = this.$refs.editor;
            let target = $(ref).find("." + id);
            let next = $(target).next();
            if(target.length){
                if(next.length && $(next).prop("tagName").toLowerCase() == "br"){
                    $(next).remove();
                }
                $(target).remove();
            }
            this.getValue($(ref).html(), true);
        },
        returnValueId(){
            let ref = this.$refs.editor;
            let clickEvent = this.getClickType == 2 ? 'dblclick' : "click";
            $(ref).on(clickEvent, function(ele){
                let target = ele.target;
                // let className = Object.values([0].classList);
                let parentClass = $(target).parent(".attr-sections");
                let id = null;
                let text = null;
                if(parentClass.length){
                    id = $(parentClass).data('id');
                    text = $(`.${this.editorPrefix + id}`).text();
                    this.selectedValue =  {
                        "id": id, "value": text
                    };
                    if(this.returnWhen == "click"){
                        this.$emit('returnId', {
                            "id": id, "value": text
                        });
                    }
                }else{
                    this.selectedValue = {
                        "id": null, "value": null
                    };
                }
                this.$emit('returnId', this.selectedValue);
            }.bind(this));
        },
        getValue(value, html = false){
            if(html == true){
                this.$emit("input", value);
            }else{
                if(this.selectedValue.id != null){
                    this.$emit('returnId', this.selectedValue);
                }
                this.$emit("input", value.target.innerHTML);
            }
        }
    },
    watch: {
        $props: {
            handler(val){

            },
            deep: true,
        },
        $attrs: {
            handler(val){
                if (val.modelValue == null || val.modelValue == "") {
                    this.value = null;
                } else {
                    if (this.firstTry == 1) {
                        this.value = val.modelValue;
                        this.firstTry = 0;
                    }
                }
            },
            deep: true,
        },
    }
}
</script>

<style scoped>
/* @import url("https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/6.5.95/css/materialdesignicons.min.css"); */
:root{
    --whiteColor: "#ffffff";
    --dark: "#010101",
}
.m-text-editor{
    background: var(--whiteColor);
    border-radius: 0.15rem;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    text-align: left;
    width: 100%;
    border: thin solid #ccc;
}


.m-text-editor .m-text-editor-header{
    padding: 5px 10px;
}
.m-text-editor .m-text-editor-body{
    padding: 10px 15px;
    margin: 0;
    outline: 0;
    background: #fff;
    color: #2f3f4f;
    min-height: 180px;
    max-height: 400px;
    overflow-y: auto;
    width: 100%;
    position: relative;
    word-break: break-word;
}

.m-text-editor .m-text-editor-body[contenteditable="false"]{
    background: #e7e7e7;
}
.m-text-editor .m-text-editor-footer{
    padding: 10px 15px;
}
.m-text-editor .m-text-editor-header{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-wrap: wrap;
    width: 100%;
    background: #fff;
    border-bottom: thin solid #ccc;
}
.m-text-editor .m-form {
    margin-top: 0;
    margin-bottom: 0;
}
.m-text-editor .m-text-editor-header button{
    border: none;
    box-shadow: none;
    padding: 2px 5px;
    background: var(--whiteColor);
}
.m-text-editor .m-text-editor-header button i{
    font-size: 18px;
}
.m-text-editor .m-text-editor-header > * {
    margin-right: 10px;
}
.m-text-editor .m-text-editor-header button:hover{
    background: rgba(0,0,0,0.3);
    color: var(--whiteColor);
}
.m-text-editor .m-text-editor-header button:hover i{
    color: var(--whiteColor);
}
.m-text-editor .card-box{
    position: relative;
}
.box-item {
    position: absolute;
    z-index: 10;
    background: #fff;
    box-shadow: 0 5px 20px rgb(0 0 0 / 30%);
    border-radius: 0.25rem;
    padding: 10px;
    right: 0;
    max-height: auto;
    overflow-y: auto;
    display: none;
}
.colors-list{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    max-width: 100%;
    min-width: 800px;
}
.colors-list .color-item{
    width: 20px;
    height: 20px;
    margin-right: 5px;
    margin-bottom: 5px;
    cursor: pointer;
    transition: all 0.2s linear;
}
.colors-list .color-item:hover{
    transform: scale(1.5);
}
.custom-radio input{
    display: inline-block;
    width: auto;
    margin-right: 3px;
}
.custom-radio{
    margin-right: 10px;
    padding-bottom: 10px;
}
.attr-sections{
    cursor: pointer!important;
    -webkit-user-select: none!important; /* Safari */
    -moz-user-select: none!important; /* Firefox */
    -ms-user-select: none!important; /* IE10+/Edge */
    user-select: none!important; /* Standard */
}

[contenteditable][placeholder]:empty:before {
  content: attr(placeholder);
  position: absolute;
  color: gray;
  background-color: transparent;
}

.m-text-editor-header img{
    height: 20px;
    width: 20px;
}

.m-text-editor-header img.bulletList{
    height: 15px;
    width: 15px;
}

.m-text-editor.invalid, .m-text-editor.invalid .m-text-editor-header {
    border-color: #c44;
    transition: all 200ms linear;
}
.m-text-editor.invalid .m-text-editor-header {
    background: #c4444410;
    transition: all 200ms linear;
}

.invalid-message {
    font-size: 14px;
    margin-top: 5px;
    color: #c44;
    transition: all 200ms linear;
}


@media (max-width: 768px) {
    .m-text-editor .card-box{
        position: inherit;
    }
    .colors-list{
        max-width: 100%;
        min-width: 100%;
        max-height: 200px;
    }
}
</style>
