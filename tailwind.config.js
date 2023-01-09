const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                "fade-in-both":
                    "fade-in-both 1.2s cubic-bezier(0.390, 0.575, 0.565, 1.000) both",
                "fade-in-down": "fade-in-down 0.4s ease-in",
                "slide-in-blurred-top":
                    "slide-in-blurred-top 1.2s cubic-bezier(0.230, 1.000, 0.320, 1.000) both",
                "swing-in-top-fwd":
                    "swing-in-top-fwd 1s cubic-bezier(0.175, 0.885, 0.320, 1.275) both",
                "shadow-drop-center":
                    "shadow-drop-center .4s cubic-bezier(.25,.46,.45,.94) both",
                "bg-gray-light":
                    "bg-gray-light .4s cubic-bezier(.25,.46,.45,.94) both",
            },
            keyframes: {
                "fade-in-both": {
                    "0%": {
                        opacity: "0",
                    },
                    "100%": {
                        opacity: "1",
                    },
                },
                "fade-in-down": {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(-10px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                "slide-in-blurred-top": {
                    "0%": {
                        "-webkit-transform":
                            "translateY(-1000px) scaleY(2.5) scaleX(0.2)",
                        transform:
                            "translateY(-1000px) scaleY(2.5) scaleX(0.2)",
                        "-webkit-transform-origin": "50% 0%",
                        "transform-origin": "50% 0%",
                        "-webkit-filter": "blur(40px)",
                        filter: "blur(40px)",
                        opacity: "0",
                    },
                    "100%": {
                        "-webkit-transform":
                            "translateY(0) scaleY(1) scaleX(1)",
                        transform: "translateY(0) scaleY(1) scaleX(1)",
                        "-webkit-transform-origin": "50% 50%",
                        "transform-origin": "50% 50%",
                        "-webkit-filter": "blur(0)",
                        filter: "blur(0)",
                        opacity: "1",
                    },
                },
                "swing-in-top-fwd": {
                    "0%": {
                        "-webkit-transform": "rotateX(-100deg)",
                        transform: "rotateX(-100deg)",
                        "-webkit-transform-origin": "top",
                        "transform-origin": "top",
                        opacity: 0,
                    },

                    "100%": {
                        "-webkit-transform": "rotateX(0deg)",
                        transform: "rotateX(0deg)",
                        "-webkit-transform-origin": "top",
                        "transform-origin": "top",
                        opacity: 1,
                    },
                },
                "shadow-drop-center": {
                    "0%": {
                        transform: "translateZ(0)",
                        "box-shadow": "0 0 0 0 transparent",
                    },
                    "100%": {
                        transform: "translateZ(50px)",
                        "box-shadow": "0 0 15px 0 rgba(0,0,0,0.2)",
                    },
                },
                "bg-gray-light": {
                    "0%": {
                        transform: "translateZ(0)",
                        "box-shadow": "0 0 0 0 transparent",
                    },
                    "100%": {
                        transform: "translateZ(50px)",
                        "background-color": "#eeeeee",
                    },
                },
            },
            colors: {
                "turquesa": "#2c8f89",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
