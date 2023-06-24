const loanAmountInput = document.querySelector(".loan-amount");
const interestRateInput = document.querySelector(".interest-rate");
const loanTenureInput = document.querySelector(".tenure");

const loanEmi = document.querySelector(".loan-emi .value");
const totalInterests = document.querySelector(".total-interest .value");
const totalAmountValue = document.querySelector(".total-amount .value");

const calbtn = document.querySelector(".cal-btn");

let loanAmount = parseFloat(loanAmountInput.value);
let interestRate = parseFloat(interestRateInput.value);
let loanTenure = parseFloat(loanTenureInput.value);

let interest = interestRate / 12 / 100;

let myChart;

const displayChart = (totalInterests,totalAmountValue) => {
    const ctx = document.getElementById('myChart').getContext('2d');
    myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Total Interest', 'Principal Loan Amount'],
            datasets: [{
                data: [totalInterests,totalAmountValue],
                backgroundColor: ["#e63946","#14213d"],
                borderWidth: 0
            }]
        },
    });
};

const updateChart = (totalInterests,totalAmountValue) => {
 myChart.data.datasets[0].data[0] = totalInterests;
 myChart.data.datasets[0].data[1] = totalAmountValue;
 myChart.update();
};

const calculateEmi = () => {
    let emi = loanAmount * interest * ((Math.pow(1 + interest, loanTenure)) / (Math.pow(1 + interest, loanTenure) - 1));

    return emi;
};

const updateData = (emi) => {
    loanEmi.innerHTML = Math.round(emi);

    let totalAmount = Math.round(loanTenure * emi);
    totalAmountValue.innerHTML = totalAmount;

    let interestPay = Math.round(totalAmount - loanAmount);
    totalInterests.innerHTML = interestPay;


    if(myChart){
        updateChart(interestPay,loanAmount);
    }else{
        displayChart(interestPay,loanAmount);
    }

};

const refreshInputValues = () =>{
    loanAmount = parseFloat(loanAmountInput.value);
    interestRate = parseFloat(interestRateInput.value);
    loanTenure = parseFloat(loanTenureInput.value);
    interest = interestRate / 12 / 100;
};

const init = () =>{
    refreshInputValues();
    let emi = calculateEmi();
    updateData(emi);
};

init();

calbtn.addEventListener("click", init)