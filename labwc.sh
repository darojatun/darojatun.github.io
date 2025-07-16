#!/usr/local/bin/zsh
export BEMENU_BACKEND=wayland
export CLUTTER_BACKEND=wayland
export GDK_BACKEND=wayland
export MOZ_ENABLE_WAYLAND=1
export QT_QPA_PLATFORM=wayland
export QT_QPA_PLATFORMTHEME="qt5ct"
export QT_WAYLAND_DISABLE_WINDOWDECORATION=0
export SDL_VIDEODRIVER=wayland
export WM=labwc
export XDG_RUNTIME_DIR=/home/TMP
export XDG_SESSION_TYPE=wayland
export XKB_DEFAULT_LAYOUT="be(nodeadkeys)"
export XKB_DEFAULT_RULES=evdev
exec labwc
