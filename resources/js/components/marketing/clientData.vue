<template>
    <div>
        <div class="content-left me-3 ">
            <p class="fs-20 text-light-black fw-bold mgb-24">{{ client.name }}</p>
            <div class="d-flex flwx-wrap corporation">
                <a href="" class="corporation-btn">Schedule <div class="mgl-12"><span class="icon-clock"><span
                                class="path1"></span><span class="path2"></span></span>
                    </div></a>
                <a href="" class="corporation-btn">Assign to <div class="mgl-12"><span class="icon-user"><span
                                class="path1"></span><span class="path2"></span></span>
                    </div></a>
                <a href="" class="corporation-btn">Email now <div class="mgl-12"><span class="icon-sms"><span
                                class="path1"></span><span class="path2"></span></span>
                    </div></a>
                <a href="" class="corporation-btn">Call <div class="mgl-12"><span class="icon-call"><span
                                class="path1"></span><span class="path2"></span></span></div></a>
            </div>

            <div class="comment">
                <div class="comment__header">
                    <p class="mb-0 fw-bold">Comments</p>
                    <span class="comment-count text-gray">12</span>
                </div>
                <div class="comment-item">
                    <div class="d-flex align-items-center">
                        <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                            alt="boston image" class="comment-img">
                        <div class="d-flex fw-bold mgl-12">Hussain M. Nasir <span class="ms-3 text-gray text-400">13 Jan
                                2021 02:09</span></div>
                    </div>
                    <p class="comment-text mb-0">Scott Hurley
                        VP/Director of Mortgage Lending
                        (401) 248-7379 (Direct)
                        (401) 248-7310 (HQ)
                        shurley@admiralsbank.com

                        Called and left a message for scott.</p>
                </div>
                <div class="comment-item">
                    <div class="d-flex align-items-center">
                        <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                            alt="boston image" class="comment-img">
                        <div class="d-flex fw-bold mgl-12">Hussain M. Nasir <span class="ms-3 text-gray text-400">13 Jan
                                2021 02:09</span></div>
                    </div>
                    <p class="comment-text mb-0">Scott Hurley
                        VP/Director of Mortgage Lending.</p>
                </div>

                <div class="comment-box">
                    <div class="comment-box-header mb-3">
                        <a href="#" class="tag">Notify</a>
                        <a href="#" class="tag-img">
                            <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                                alt="boston image" class="">
                            <span>Hussain M. Nasir</span>
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 9L9 1" stroke="#7E829B" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 9L1 1" stroke="#7E829B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <textarea name="" id="" rows="5" class="comment-box-textarea"
                        placeholder="Write here..."></textarea>
                    <div class="text-end">
                        <button class="button button-primary py-2 px-3">Comment</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="group status-group">
                <label for="role" class="d-block text-light-black mb-2">Status</label>
                <div class="position-relative">
                    <m-select :options="statuses" object item-text="status" item-value="id" v-model="status">
                    </m-select>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            statuses: []
        },
        data: () => ({
            client: []
        }),
        methods: {
            setClientData(client){
                this.client = client
            }
        }
    }
</script>
