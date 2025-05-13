<form id="agkatan" method="POST" action="{{ route('dashboard') }}">
    @csrf
    <div class="modal fade" id="yearModal" tabindex="-1" aria-labelledby="yearModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="yearModalLabel">Pilih Tahun Angkatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="yearPicker" class="d-grid gap-2"
                        style="grid-template-columns: repeat(5, 1fr); display: grid;">
                        <!-- Konten Tahun Angkatan -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clearBtn" class="btn btn-outline-secondary">Reset</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    const yearPicker = document.getElementById("yearPicker");
    const input = document.getElementById("selectedYears");
    const clearBtn = document.getElementById("clearBtn");

    let selectedStart = null;
    let selectedEnd = null;

    // Generate year buttons
    for (let y = 2000; y <= new Date().getFullYear(); y++) {
        const btn = document.createElement("div");
        btn.textContent = y;
        btn.className = "year-option";
        btn.dataset.year = y;
        yearPicker.appendChild(btn);
    }

    yearPicker.addEventListener("click", (e) => {
        if (!e.target.classList.contains("year-option")) return;
        const year = parseInt(e.target.dataset.year);

        if (selectedStart === null || (selectedStart !== null && selectedEnd !== null)) {
            selectedStart = year;
            selectedEnd = null;
        } else if (year >= selectedStart) {
            selectedEnd = year;
        } else {
            selectedStart = year;
            selectedEnd = null;
        }

        // Update button styles
        document.querySelectorAll(".year-option").forEach(btn => {
            btn.classList.remove("selected");
        });

        if (selectedStart !== null) {
            document.querySelector(`.year-option[data-year='${selectedStart}']`).classList.add("selected");
        }
        if (selectedEnd !== null) {
            for (let y = selectedStart; y <= selectedEnd; y++) {
                document.querySelector(`.year-option[data-year='${y}']`)?.classList.add("selected");
            }
            input.value = `${selectedStart} - ${selectedEnd}`;
        }
    });

    clearBtn.addEventListener("click", () => {
        selectedStart = null;
        selectedEnd = null;
        input.value = "";
        document.querySelectorAll(".year-option").forEach(btn => {
            btn.classList.remove("selected");
        });
    });
</script>
