<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="w-full">
        <items :items="value" :field="field" @update:modelValue="handleChange" :edit="true"></items>
        <p v-if="hasError" class="my-2 text-danger">
           {{ firstError }}
        </p>
      </div>
      <!--input
        :id="field.attribute"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
      /-->
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Items from './Items.vue';


export default {
  components: { Items },
  mixins: [FormField, HandlesValidationErrors],
  props: ['resourceName', 'resourceId', 'field'],
  data() {
    return {
      value: [],
    };
  },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
        this.value = JSON.parse(this.field.value) || []
	console.log(this.value);
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, JSON.stringify(this.value) || [])
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
	console.log('model updated');
      this.value = value
    }
  },
}
</script>
