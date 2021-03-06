<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Order Per Day</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class="text-bold text-lg" id="totalOrderThisWeek"></span>
                <span>Total Order</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success" id="growthThisWeekColor">
                    <i class="fas fa-arrow-up" id="growthThisWeekIcon"></i>
                    <span id="growthThisWeek"></span>
                </span>
                <span class="text-muted">Since last week</span>
            </p>
        </div>

        <div class="position-relative mb-4">
            <canvas id="visitors-chart" height="200"></canvas>
        </div>

        <div class="d-flex flex-row justify-content-end">
            <span class="mr-2">
                <i class="fas fa-square text-primary"></i> This Week
            </span>

            <span>
                <i class="fas fa-square text-gray"></i> Last Week
            </span>
        </div>
    </div>
</div>
