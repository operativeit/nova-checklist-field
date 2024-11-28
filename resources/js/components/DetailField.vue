<template>
  <PanelItem :index="index" :field="field">
     <!--h4 class="font-normal text-80" v-text="field.indexName"></h4-->

     <template #value>
        <p class="text-90 flex">
            <items :items="value" :field="field" :edit="false"></items>
        </p>
     </template>
  </PanelItem>
</template>

<script>
import Items from './Items.vue';
export default {
  components: { Items },
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
  computed:{
            value(){
                if(this.field.value){
                    return JSON.parse(this.field.value) || [];
                }
                return [];
            },
  },
}
</script>
