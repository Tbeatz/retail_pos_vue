<template>
    <Transition name="fade">
        <slot />
    </Transition>
</template>
<style>
    .fade-enter-active {
        transition: all 0.3s ease-out;
    }

    .fade-leave-active {
        transition: all 0.3s ease-in;
    }

    .fade-enter-from, .fade-leave-to {
        opacity: 0;
    }
</style>
