<template>
    <div class="box-wrap">
        <div class="box">
            <div class="box-background">
                <div class="form-fields-container">

                    <slot></slot>

                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
    
    .form-fields-container {
        @apply flex-auto px-4 lg:px-10 py-10
    }
</style>