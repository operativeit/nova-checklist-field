<template>
    <div class="my-3" tabindex="-1" @click="selectHandle" v-click-out-side="unselectHandle">
        <div class="flex p-2 justify-between" v-if="$parent.edit" :class="selectedClasses" >
            <div class="flex w-full">
                <checkbox
                    :value="item.id"
                    :checked="isChecked"
                    @input="toggleCheckbox"
                />
                <label
                    :for="item.id"
                    class="pl-2 w-full flex justify-between"
                >
                    <input ref="input" class="w-full bg-transparent outline-none p-0 m-0" v-if="editing" @keydown.enter="toggleEditing" v-model="item.body" v-click-out-side="toggleEditing"/>
                    <div class="w-full" @dblclick="toggleEditing" v-else>{{item.body}}</div>
                </label>
            </div>
            <div class="flex" v-if="selected">
                <button type="button"
                    class="shadow bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold h-6 px-2"
                    @click.prevent="modal.show=true"
                >
                    <heroicons-outline-trash height="16" width="16" />
                </button>
            </div>
        </div>
        <div v-else class="flex">
            <div class="flex items-center">
                <div class="flex" v-if="isChecked">
		    <heroicons-outline-check height="24" width="24" class="text-green" />
                </div>
                <div class="flex text-red" v-else>
                    <heroicons-outline-x height="24" width="24" />
                </div>
            </div>
            <div class="flex flex-row flex-col">
                <span :class="isChecked ? 'line-through text-80' : ''" v-text="item.body"></span>
                <span class="text-70 text-xs" v-if="secondLineText" v-text="secondLineText"></span>
            </div>
        </div>
    </div>
    <ConfirmActionModal :show="modal.show" @confirm="destroy" @close="modal.show=false" :action="modal.action" />

</template>
<script>
    import moment from 'moment';
    import { ref, nextTick } from 'vue'
    import clickOutSide from "@mahdikhashan/vue3-click-outside";
	
    export default {
        props: ['item', 'field'],
        directives: {
            clickOutSide,
        },
        data() {
            return {
               modal: {
                   show: false,
                   action: {
                     name: this.__('nova_checklist_field.delete_item'),
                     confirmText:  this.__('nova_checklist_field.confirm_text'),
                     cancelButtonText: this.__('nova_checklist_field.cancel_button_text'),
                     confirmButtonText: this.__('nova_checklist_field.confirm_button_text'),
                     destructive: true,
                     fields: [],                    
                   }
               },
               selected: false,
               editing: false,
            };
        },
        methods: {
            toggleEditing() {
                this.editing = !this.editing;
                if (this.editing) {
                    nextTick(() => {
                        this.$refs.input.focus();
                    });
                }
            },
            toggleCheckbox() {
                if (this.item.completed_at) {
                    this.item.completed_by = null;
                    this.item.completed_at = null;
                } else {
                    this.item.completed_by = this.field.user;
                    this.item.completed_at = Date.now();
                }
            },
            destroy(){
                this.$emit('deleted', this.id);
            },
            selectHandle() {
                this.selected = true;
            },
            unselectHandle() {
                if (this.selected) this.selected = false;
            }
        },
        computed: {
	    selectedClasses() {
              return this.selected?'rounded bg-gray-100 text-primary':'';
            },
            isChecked() {
                return this.item.completed_at != null
            },
            completedAt(){
                if(this.item.completed_at){
                    return moment(this.item.completed_at).fromNow()

                }
                return null;
            },
            secondLineText(){
                if(this.completedAt && this.field.user){
                    return `${this.field.user}, ${this.completedAt}`;
                }
                if(this.field.show_timestamps && this.completedAt){
                    return this.completedAt;
                }
                if(this.field.user){
                    return this.item.completed_by;
                }
                return null
            }
        }
    }
</script>
