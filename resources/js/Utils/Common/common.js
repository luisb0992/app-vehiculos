/**
 * Funcionalidades/util js comunes a todos los componentes
 */

// año en curso
export const currentYear = new Date().getFullYear();

// verificar si hay cámaras disponibles
export const hasCamera = () => {
    return navigator &&
        navigator.mediaDevices &&
        navigator.mediaDevices.getUserMedia
        ? true
        : false;
};
