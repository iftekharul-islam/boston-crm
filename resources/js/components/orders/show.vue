<template>
    <div id="order-details-view-page">
        <order-header :order="order" :share-url="shareUrl" :diff_in_days="diff_in_days" :diff_in_hours="diff_in_hours"></order-header>
        <div class="order-details-box-main row">
            <div class="order-details__left col-md-6">
                <basic-info :order="order"  :order-id="order_id"></basic-info>
                <property-info :appraisal_types="appraisal_types" :order="order"  :order-id="order_id"></property-info>
                <borrower :order="order"  :order-id="order_id"></borrower>
                <contact :order="order"  :order-id="order_id"></contact>
                <inspection :order="order" :appraisers="appraisers"></inspection>
                <issues></issues>
            </div>
            <div class="order-details__right col-md-6">
                <appraisal-details :order="order" :appraisers="appraisers" :loan-types="loan_types" :order-id="order_id"></appraisal-details>
                <provided-services :order="order" :appraisal-types="appraisal_types" :order-id="order_id"></provided-services>
                <client-info :order="order" :all-amc="all_amc" :all-lender="all_lender" :order-id="order_id"></client-info>
                <call-log :order="order"></call-log>
                <map-view :order="order"></map-view>
            </div>
        </div>
        <div class="row">
            <workflow :order="order" :norewrite="noRewrite" :appraisers="appraisers" :permissions="user_permissions" :role="user_role" :users="all_users"></workflow>
            <history :order="order"></history>
        </div>
        <div class="mgt-32">
            <files :order-files="order_files" :order-id="order_id" :order-file-types="order_file_types"></files>
        </div>

        <div class="note-grid">
            <invoice :order="order"></invoice>
            <notes :order="order"></notes>
            <activity-log :order="order" :order-id="order_id"></activity-log>
        </div>
    </div>
</template>

<script>

export default {
    props: [
        'order',
        'order_id',
        'share-url',
        'diff_in_days',
        'diff_in_hours',
        'appraisal_types',
        'appraisers',
        'loan_types',
        'all_amc',
        'all_lender',
        'noRewrite',
        'user_permissions',
        'user_role',
        'all_users',
        'order_files',
        'order_file_types',
    ]
}

</script>