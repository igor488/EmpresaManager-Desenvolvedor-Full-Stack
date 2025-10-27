import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// JavaScript para handle de download
document.addEventListener('livewire:initialized', () => {
    Livewire.on('download-file', (data) => {
        const { url, filename } = data;

        // Criar link temporário para download
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        link.target = '_blank';

        // Disparar click automático
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        console.log('Download iniciado:', filename);
    });
});
