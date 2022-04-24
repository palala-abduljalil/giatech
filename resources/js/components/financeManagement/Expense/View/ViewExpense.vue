<template>
    <section data-app>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card-box">
                        <ul class="nav nav-pills navtab-bg">
                            <li class="nav-item">
                                <a
                                    href="#expense-info"
                                    data-toggle="tab"
                                    aria-expanded="true"
                                    class="nav-link ml-0 active"
                                >
                                    Expense Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="#attachments"
                                    data-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link"
                                >
                                    Attachments
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div
                                class="tab-pane show active"
                                id="expense-info"
                            >
                                <view-expense-information :expense-id="expenseId"/>
                            </div>
                            <div class="tab-pane" id="attachments">
                                <view-expense-attachments :expense-id="expenseId"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ViewExpenseInformation from "./ViewExpenseInformation";
import ViewExpenseAttachments from "./ViewExpenseAttachments/ViewExpenseAttachments";
export default {
    props: {
        expenseId: Number,
    },
    components: {
        ViewExpenseAttachments,
        ViewExpenseInformation,
    },
};
</script>

<style lang="scss" scoped>
.card-box {
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    padding: 1.5rem;
    margin-bottom: 24px;
    border-radius: 0.25rem;
}
.avatar-xl {
    height: 6rem;
    width: 6rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
    color: #fff;
    background-color: #007bff;
}
.nav-pills .nav-link {
    border-radius: 0.25rem;
}
.navtab-bg li > a {
    background-color: #f7f7f7;
    margin: 0 5px;
}
.nav-pills > li > a,
.nav-tabs > li > a {
    color: #6c757d;
    font-weight: 600;
}
.mb-4,
.my-4 {
    margin-bottom: 2.25rem !important;
}
.tab-content {
    padding: 20px 0 0 0;
}
.progress-sm {
    height: 5px;
}
.m-0 {
    margin: 0 !important;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
</style>
