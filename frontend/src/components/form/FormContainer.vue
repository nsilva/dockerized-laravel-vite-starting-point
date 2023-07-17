<template>
    <div class="form-wrap">
        <div class="form-box">
            <div class="form-background">
                <div class="form-fields-container">

                    <slot></slot>

                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
    .form-wrap {
        @apply flex content-center items-center justify-center h-full
    }

    .form-box {
        @apply w-full lg:w-4/12 px-4
    }

    .form-background {
        @apply relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0
    }

    .form-fields-container {
        @apply flex-auto px-4 lg:px-10 py-10
    }
</style>