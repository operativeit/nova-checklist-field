import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-checklist-field', IndexField)
  app.component('detail-nova-checklist-field', DetailField)
  app.component('form-nova-checklist-field', FormField)
})
