/* global Chart:false */

$(function () {
    "use strict";

    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",

        minimumFractionDigits: 2,
    });

    var dailyLabel = [];
    var thisWeekValues = [];
    var lastWeekValues = [];
    var totalOrderThisWeek = 0;
    var growthThisWeek = "";
    var monhtlyLabel = [];
    var thisYearValues = [];
    var lastYearValues = [];
    var totalOrderThisYear = 0;
    var growthThisYear = "";

    var ticksStyle = {
        fontColor: "#495057",
        fontStyle: "bold",
    };

    var mode = "index";
    var intersect = true;

    var $salesChart = $("#sales-chart");
    // eslint-disable-next-line no-unused-vars
    async function getOrderData() {
        const response = await fetch("/orders/finddata");
        const jsonData = await response.json(); //extract JSON from the http response

        dailyLabel = jsonData.thisWeek.keys;
        thisWeekValues = jsonData.thisWeek.values;
        lastWeekValues = jsonData.lastWeek.values;
        totalOrderThisWeek = jsonData.totalOrderThisWeek;
        growthThisWeek = jsonData.growthThisWeek + " %";

        monhtlyLabel = jsonData.thisYear.keys;
        thisYearValues = jsonData.thisYear.values;
        lastYearValues = jsonData.lastYear.values;
        totalOrderThisYear = jsonData.totalOrderThisYear;
        growthThisYear = jsonData.growthThisYear + " %";
    }

    function setGrowthThisWeek() {
        if (growthThisWeek.includes("-")) {
            $("#growthThisWeekColor").removeClass("text-success");
            $("#growthThisWeekColor").addClass("text-danger");

            $("#growthThisWeekIcon").removeClass("fa-arrow-up");
            $("#growthThisWeekIcon").addClass("fa-arrow-down");
        } else {
            $("#growthThisWeekColor").removeClass("text-danger");
            $("#growthThisWeekColor").addClass("text-success");

            $("#growthThisWeekIcon").addClass("fa-arrow-up");
            $("#growthThisWeekIcon").removeClass("fa-arrow-down");
        }

        $("#growthThisWeek").html(growthThisWeek);
    }

    function setGrowthThisYear() {
        if (growthThisYear.includes("-")) {
            $("#growthThisYearColor").removeClass("text-success");
            $("#growthThisYearColor").addClass("text-danger");

            $("#growthThisYearIcon").removeClass("fa-arrow-up");
            $("#growthThisYearIcon").addClass("fa-arrow-down");
        } else {
            $("#growthThisYearColor").removeClass("text-danger");
            $("#growthThisYearColor").addClass("text-success");

            $("#growthThisYearIcon").addClass("fa-arrow-up");
            $("#growthThisYearIcon").removeClass("fa-arrow-down");
        }

        $("#growthThisYear").html(growthThisYear);
    }

    async function loadChart() {
        await getOrderData();

        $("#totalOrderThisWeek").html(totalOrderThisWeek);
        setGrowthThisWeek(growthThisWeek);

        $("#totalOrderThisYear").html(formatter.format(totalOrderThisYear));
        setGrowthThisYear();

        var salesChart = new Chart($salesChart, {
            type: "bar",
            data: {
                labels: monhtlyLabel,
                datasets: [
                    {
                        backgroundColor: "#007bff",
                        borderColor: "#007bff",
                        data: thisYearValues,
                    },
                    {
                        backgroundColor: "#ced4da",
                        borderColor: "#ced4da",
                        data: lastYearValues,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect,
                },
                hover: {
                    mode: mode,
                    intersect: intersect,
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: "4px",
                                color: "rgba(0, 0, 0, .2)",
                                zeroLineColor: "transparent",
                            },
                            ticks: $.extend(
                                {
                                    beginAtZero: true,

                                    // Include a dollar sign in the ticks
                                    callback: function (value) {
                                        if (value >= 1000) {
                                            value /= 1000;
                                            value += "k";
                                        }

                                        return "IDR " + value;
                                    },
                                },
                                ticksStyle
                            ),
                        },
                    ],
                    xAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: ticksStyle,
                        },
                    ],
                },
            },
        });

        var $visitorsChart = $("#visitors-chart");
        // eslint-disable-next-line no-unused-vars
        var visitorsChart = new Chart($visitorsChart, {
            data: {
                labels: dailyLabel,
                datasets: [
                    {
                        type: "line",
                        data: thisWeekValues,
                        backgroundColor: "transparent",
                        borderColor: "#007bff",
                        pointBorderColor: "#007bff",
                        pointBackgroundColor: "#007bff",
                        fill: false,
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                    },
                    {
                        type: "line",
                        data: lastWeekValues,
                        backgroundColor: "tansparent",
                        borderColor: "#ced4da",
                        pointBorderColor: "#ced4da",
                        pointBackgroundColor: "#ced4da",
                        fill: false,
                        // pointHoverBackgroundColor: '#ced4da',
                        // pointHoverBorderColor    : '#ced4da'
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect,
                },
                hover: {
                    mode: mode,
                    intersect: intersect,
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: "4px",
                                color: "rgba(0, 0, 0, .2)",
                                zeroLineColor: "transparent",
                            },
                            ticks: $.extend(
                                {
                                    beginAtZero: true,
                                    suggestedMax: 50,
                                },
                                ticksStyle
                            ),
                        },
                    ],
                    xAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: ticksStyle,
                        },
                    ],
                },
            },
        });
    }

    loadChart();
});

// lgtm [js/unused-local-variable]
