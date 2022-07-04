<template>
    <div class="row ">
        <div class="col-12">
            <!-- Files -->
            <div class="order-details-box bg-white">
                <div class="box-header">
                    <p class="fw-bold text-light-black fs-20 mb-0">Workflow Files</p>
                </div>
                <div class="box-body">
                    <!-- document -->
                    <div class="document">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <p class="fw-bold text-light-black">Inspection Files</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in inspectionFiles">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <span class="text-light-black d-inline-block mgl-12 file-name"><a
                                            :href="file.original_url" target="_blank" download>{{ file.name }}</a></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <p class="fw-bold text-light-black">Report Preparation Files</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in reportFiles">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <span class="text-light-black d-inline-block mgl-12 file-name"><a
                                            :href="file.original_url" target="_blank" download>{{ file.name }}</a></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <p class="fw-bold text-light-black">Report Analysis Files</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in reportAnalysisFiles">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <span class="text-light-black d-inline-block mgl-12 file-name"><a
                                            :href="file.original_url" target="_blank" download>{{ file.name }}</a></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <p class="fw-bold text-light-black">Quality Assurance Files</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in qaFiles">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <span class="text-light-black d-inline-block mgl-12 file-name"><a
                                            :href="file.original_url" target="_blank" download>{{ file.name }}</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <p class="fw-bold text-light-black">Report Rewrite Files</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in reportRewriteFiles">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <span class="text-light-black d-inline-block mgl-12 file-name"><a
                                            :href="file.original_url" target="_blank" download>{{ file.name }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            order: []
        },
        data() {
            return {
                inspectionFiles: [],
                reportFiles: [],
                reportAnalysisFiles: [],
                reportRewriteFiles: [],
                qaFiles: []
            }
        },
        created() {
            this.getWorkflowFiles(this.order)
            this.$root.$on('wk_flow_toast', (res) => {
                this.orderData = res.data;
                this.getWorkflowFiles(this.orderData);
            });
        },
        methods: {
            getWorkflowFiles(order) {
                this.inspectionFiles = order.inspection && order.inspection.attachments ? order.inspection.attachments : []
                this.reportFiles = order.report && order.report.attachments ? order.report.attachments : []
                this.reportAnalysisFiles = order.analysis && order.analysis.attachments ? order.analysis.attachments : []
                this.reportRewriteFiles = order.report_rewrite && order.report_rewrite.attachments ? order.report_rewrite.attachments : []
                this.qaFiles = order.quality_assurance && order.quality_assurance.attachments ? order.quality_assurance.attachments : []
            }
        }
    }
</script>
