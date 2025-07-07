document.addEventListener("DOMContentLoaded", function () {
    let activeAccordionId = null;

    // Dengarkan event collapse Bootstrap
    const collapses = document.querySelectorAll('.accordion-collapse');
    collapses.forEach(collapse => {
        collapse.addEventListener('shown.bs.collapse', function () {
            // Ambil parent .accordion-item dan simpan ID-nya
            const accordionItem = this.closest('.accordion-item');
            if (accordionItem) {
                activeAccordionId = accordionItem.id;
                console.log('Selected accordion:', activeAccordionId);
            }
        });
    });

    // Tombol NEXT diklik
    const nextButton = document.getElementById("next-button");
    if (nextButton) {
        nextButton.addEventListener("click", function () {
            console.log("Next button clicked. activeAccordionId = ", activeAccordionId);
            if (!activeAccordionId) {
                alert("Silakan pilih metode pembayaran terlebih dahulu.");
                return;
            }

            // Redirect sesuai ID
            switch (activeAccordionId) {
                case "credit-card":
                    window.location.href = "/pembayaran/credit-card";
                    break;
                case "qris":
                    window.location.href = "/pembayaran/qris";
                    break;
                case "bca-va":
                    window.location.href = "/pembayaran/bca";
                    break;
                case "mandiri-va":
                    window.location.href = "/pembayaran/mandiri";
                    break;
                case "blu-va":
                    window.location.href = "/pembayaran/blu";
                    break;
                case "gopay":
                    window.location.href = "/pembayaran/gopay";
                    break;
                case "ovo":
                    window.location.href = "/pembayaran/ovo";
                    break;
                case "shopeepay":
                    window.location.href = "/pembayaran/spay";
                    break;
                default:
                    alert("Metode pembayaran tidak dikenali.");
            }
        });
    }
});
