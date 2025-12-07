if (!window.ReportCharts) {
    window.ReportCharts = {
        instances: {},

        render(charts) {
            if (!Array.isArray(charts)) return;

            charts.forEach(cfg => {
                const el = document.getElementById(cfg.id);
                if (!el) return;

                if (window.ReportCharts.instances[cfg.id]) {
                    window.ReportCharts.instances[cfg.id].destroy();
                }

                window.ReportCharts.instances[cfg.id] = new Chart(el, {
                    type: cfg.type,
                    data: {
                        labels: cfg.labels,
                        datasets: [{
                            label: cfg.title,
                            data: cfg.data
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            },
                            x: {
                                ticks: { autoSkip: true, maxRotation: 45 }
                            }
                        }
                    }
                });
            });
        }
    };
}


window.downloadChartPNG = function (id, filename = 'chart.png') {
    const el = document.getElementById(id);
    if (!el) return;
    const a = document.createElement('a');
    a.href = el.toDataURL('image/png', 1.0);
    a.download = filename;
    a.click();
};

window.downloadChartJPG = function (id, filename = 'chart.jpg') {
    const src = document.getElementById(id);
    if (!src) return;

    const tmp = document.createElement('canvas');
    tmp.width = src.width;
    tmp.height = src.height;

    const ctx = tmp.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, tmp.width, tmp.height);
    ctx.drawImage(src, 0, 0);

    const a = document.createElement('a');
    a.href = tmp.toDataURL('image/jpeg', 0.92);
    a.download = filename;
    a.click();
};

window.downloadChartPDF = async function (id, filename = 'chart.pdf') {
    const el = document.getElementById(id);
    if (!el) return;

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });

    const imgData = el.toDataURL('image/png', 1.0);
    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    const margin = 24;
    const maxW = pageWidth - margin * 2;
    const maxH = pageHeight - margin * 2;

    const ratio = el.width / el.height;

    let w = maxW;
    let h = w / ratio;

    if (h > maxH) {
        h = maxH;
        w = h * ratio;
    }

    pdf.addImage(imgData, 'PNG', (pageWidth - w) / 2, (pageHeight - h) / 2, w, h);
    pdf.save(filename);
};
