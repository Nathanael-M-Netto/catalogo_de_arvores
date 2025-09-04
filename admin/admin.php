<?php
// ... código PHP existente ...
?>

<main class="container mx-auto px-6 pt-28 pb-10">
<!-- ... HTML existente ... -->
    <div id="qrcode-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-card max-w-sm w-full text-center">
            <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">QR Code para a Árvore</h3>
            <div id="qrcode-container" class="mb-4 flex justify-center"></div>
            <div class="flex gap-4 mt-6">
                <button id="imprimir-qrcode-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg transition-colors">
                    Imprimir
                </button>
                <button id="salvar-qrcode-btn" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-5 rounded-lg transition-colors">
                    Salvar
                </button>
                <button id="fechar-modal-btn" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-5 rounded-lg transition-colors">
                    Fechar
                </button>
            </div>
        </div>
    </div>
<!-- ... resto do HTML existente ... -->
</main>

<?php
// ... includes do footer ...
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gerarQrCodeBtn = document.getElementById('gerar-qrcode-btn');
    const qrCodeModal = document.getElementById('qrcode-modal');
    const qrCodeContainer = document.getElementById('qrcode-container');
    const imprimirQrCodeBtn = document.getElementById('imprimir-qrcode-btn');
    const salvarQrCodeBtn = document.getElementById('salvar-qrcode-btn');
    const fecharModalBtn = document.getElementById('fechar-modal-btn');
    const idArvoreInput = document.getElementById('id_arvore');

    if (gerarQrCodeBtn) {
        gerarQrCodeBtn.addEventListener('click', function() {
            const arvoreId = idArvoreInput.value;
            if (arvoreId) {
                qrCodeContainer.innerHTML = '<p>Gerando QR Code...</p>'; // Mensagem de carregamento
                qrCodeModal.classList.remove('hidden');

                // Busca o SVG do QR Code no backend.
                fetch(`gerar_qrcode.php?id=${arvoreId}`)
                    .then(response => {
                        // Verifica se a requisição foi bem sucedida
                        if (!response.ok) {
                            throw new Error(`Erro na resposta do servidor: ${response.statusText}`);
                        }
                        return response.text();
                    })
                    .then(qrCodeSvg => {
                        // Insere o SVG no container e exibe o modal
                        qrCodeContainer.innerHTML = qrCodeSvg;
                    })
                    .catch(error => {
                        // Em caso de erro, exibe uma mensagem amigável
                        console.error('Erro ao gerar QR Code:', error);
                        qrCodeContainer.innerHTML = '<p class="text-red-500 font-semibold">Não foi possível gerar o QR Code. Verifique o console para mais detalhes.</p>';
                    });
            } else {
                alert('Por favor, carregue uma árvore primeiro para gerar o QR Code.');
            }
        });
    }

    if (fecharModalBtn) {
        fecharModalBtn.addEventListener('click', function() {
            qrCodeModal.classList.add('hidden');
        });
    }
    
    // Fecha o modal se clicar fora da área do conteúdo
    qrCodeModal.addEventListener('click', function(event) {
        if (event.target === qrCodeModal) {
            qrCodeModal.classList.add('hidden');
        }
    });

    if (imprimirQrCodeBtn) {
        imprimirQrCodeBtn.addEventListener('click', function() {
            const svgEl = qrCodeContainer.querySelector('svg');
            if (!svgEl) {
                alert('QR Code não encontrado para impressão.');
                return;
            }
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Imprimir QR Code</title></head><body style="text-align:center; margin-top: 50px;">');
            printWindow.document.write(svgEl.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus(); // Necessário para alguns navegadores
            setTimeout(function(){ printWindow.print(); }, 500); // Atraso para garantir o carregamento
        });
    }

    if (salvarQrCodeBtn) {
        salvarQrCodeBtn.addEventListener('click', function() {
            const svgEl = qrCodeContainer.querySelector('svg');
            if (!svgEl) {
                alert('QR Code não encontrado para salvar.');
                return;
            }
            
            // Adiciona um fundo branco ao SVG para o PNG não ter fundo transparente
            svgEl.style.backgroundColor = 'white';

            const svgData = new XMLSerializer().serializeToString(svgEl);
            const canvas = document.createElement('canvas');
            // Aumenta a resolução para melhor qualidade
            const scale = 4;
            canvas.width = svgEl.width.baseVal.value * scale;
            canvas.height = svgEl.height.baseVal.value * scale;

            const ctx = canvas.getContext('2d');
            const img = new Image();
            img.onload = function() {
                // Preenche o fundo do canvas com branco
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                // Desenha a imagem do QR Code
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                
                // Cria o link para download
                const downloadLink = document.createElement('a');
                downloadLink.download = `qrcode_arvore_${idArvoreInput.value}.png`;
                downloadLink.href = canvas.toDataURL('image/png');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            };
            // Converte o SVG para um formato que pode ser usado na tag <img>
            img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
        });
    }
});
</script>
