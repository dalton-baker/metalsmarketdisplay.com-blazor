using MetalsMarketDisplay.Com.Common;
using Microsoft.AspNetCore.Components;
using MudBlazor;
using Newtonsoft.Json;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Json;
using System.Threading.Tasks;

namespace MetalsMarketDisplay.Com.Pages
{
    public partial class Index
    {
        [Inject]
        public HttpClient Http { get; set; }

        private MetalsHistory history;

        public List<ChartSeries> Series = new();
        readonly ChartOptions options = new()
        {
            
        };
        public string[] XAxisLabels = {
            "12PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "2PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "4PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "6PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "8PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "10PM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "12AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "2AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "4AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "6AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "8AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
            "10AM", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
        };

        protected override async Task OnInitializedAsync()
        {
            

            options.YAxisFormat = "c2";
            //options.XAxisLines = true;
            options.YAxisTicks = 5;
            options.DisableLegend = true;

            string historyString = await Http.GetStringAsync("market-data/history.json");
            MetalsHistory tempHistory = JsonConvert.DeserializeObject<MetalsHistory>(historyString);

            history = new()
            {
                Gold = tempHistory.Gold.OrderBy(g => g.UpdateTime).ToList(),
                Silver = tempHistory.Silver.OrderBy(s => s.UpdateTime).ToList(),
            };

            //history = await Http.GetFromJsonAsync<MetalsHistory>("market-data/history.json");

            Series.Add(new ChartSeries { Name = "Silver", Data = history.Silver.Select(h => h.Ask).ToArray() });
        }
    }
}
