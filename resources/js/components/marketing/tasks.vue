<template>
    <b-modal id="tasks" size="md" title="Tasks">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="addTasksForm">
                        <ValidationProvider class="group d-block" name="Subject" rules="required" v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Subject <span
                                        class="text-danger require"></span></label>
                                <input type="text" class="dashboard-input w-100" v-model="task.subject">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block mb-2 dashboard-label" name="Description" rules="required"
                            v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-1">Description <span
                                        class="text-danger require"></span></label>
                                <text-editor v-model="task.description" placeholder="Enter description here...">
                                </text-editor>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </validationProvider>
                        <ValidationProvider class="d-block dashboard-label group" name="Due date"
                            rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Due date <span
                                        class="text-danger require"></span></label>
                                <v-date-picker v-model="task.due_date"
                                    :available-dates='{ start: new Date(), end: null }'>
                                    <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                        <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" />
                                    </template>
                                </v-date-picker>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block dashboard-label group" name="Set reminder"
                            rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Set reminder <span
                                        class="text-danger require"></span></label>
                                <v-date-picker mode="datetime" v-model="task.reminder"
                                    :available-dates='{ start: new Date(), end: null }'>
                                    <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                        <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" />
                                    </template>
                                </v-date-picker>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button type="button" variant="secondary" @click="$bvModal.hide('tasks')">Close</b-button>
            <b-button type="button" variant="primary" @click="saveTask">Save</b-button>
        </div>
    </b-modal>
</template>
<script>
    import Calendar from 'v-calendar/lib/components/calendar.umd'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    Vue.component('VCalendar', Calendar)
    Vue.component('VDatePicker', DatePicker)
    export default {
        name: 'tasks',
        props: {
            client: []
        },
        data: () => ({
            task: {
                client_id: 0,
                subject: '',
                description: '',
                due_date: '',
                reminder: '',
            },
        }),
        watch: {
            client: {
                handler(val) {
                    this.task.client_id = val.id ?? 0
                },
                deep: true
            }
        },
        methods: {
            saveTask() {
                this.$refs.addTasksForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        formData.append('client_id',this.task.client_id)
                        formData.append('subject',this.task.subject)
                        formData.append('description',this.task.description)
                        formData.append('due_date',this.task.due_date)
                        formData.append('reminder',this.task.reminder)
                        this.$boston.post('save-task', formData)
                            .then(res => {
                                this.$root.$emit('client_res', res)
                                this.$root.$emit('toast_msg', res)
                                this.$bvModal.hide('tasks')
                                this.task = {}
                            })
                            .catch(err => {
                                console.error(err)
                            })
                    }
                })
            },
        }
    }
</script>
