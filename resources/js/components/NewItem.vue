<template>
    <div>
        <div class="flex">
            <input
                :id="item.id"
                type="text"
                name="new-item"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="placeholderText"
                v-model="item.body"
                v-on:keydown.enter.prevent="addItem"
            />
                <button type="button"
                    :disabled="item.body.length == 0"
                    v-show="item.body.length > 0"
                    class="shadow bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded font-bold h-9 ml-2 px-2"
                    @click.prevent="addItem"
                >
                    <heroicons-outline-plus height="18" width="18" />
                </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['field'],
        data() {
            return {
                item: this.freshItem()
            };
        },
        methods: {
            freshItem(){
                return {
                    id: this.uuidv4(),
                    body: '',
                    created_at: null,
                    created_by: null,
                    completed_at: null,
                    completed_by: null,
                };
            },
            addItem() {
                if(this.item.body.length > 0){
                    if(this.field.user){
                        this.item.created_by = this.field.user;
                    }
                    this.item.created_at = Date.now();
                    this.$emit('created', this.item);
                    this.item = this.freshItem();
                }
            },
            uuidv4() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }
        },
        computed: {
            placeholderText(){
                return (this.field.placeholder || this.__('nova_checklist_field.add_item') ) + (this.field.placeholder_count ? (this.$parent.items.length+1) : '');
            }
        }
    }
</script>
