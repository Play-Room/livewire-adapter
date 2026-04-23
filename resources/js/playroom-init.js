import playRoomPlugin from '@play-room/alpinejs-adapter';

document.addEventListener('alpine:init', () => {
    Alpine.plugin(playRoomPlugin);
});
