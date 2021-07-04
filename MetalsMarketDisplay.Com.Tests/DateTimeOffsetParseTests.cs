using MetalsMarketDisplay.Com.Common;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;

namespace MetalsMarketDisplay.Com.Tests
{
    [TestClass]
    public class JsonParseTests
    {
        public TestContext TestContext { get; set; }

        [TestMethod]
        public void DateTimeOffsetStringParseTest()
        {
            string dateString = @"07\/04\/2021 07:25:03 UTC";

            dateString = dateString.Replace(@"\/", "/");

            DateTimeOffset result = DateTimeOffset.ParseExact(dateString.Replace(@"\/", "/"), @"MM/dd/yyyy HH:mm:ss UTC",
                CultureInfo.InvariantCulture.DateTimeFormat, DateTimeStyles.AssumeUniversal);

            TestContext.WriteLine(result.ToString());



            dateString = @"07/04/2021 20:10:19 +00:00";

            result = DateTimeOffset.Parse(dateString);
            TestContext.WriteLine(result.ToString());
        }

        [TestMethod]
        public void MiscFileRead()
        {
            using StreamReader r = new("JsonFileExamples/misc.json");
            string json = r.ReadToEnd();
            MiscMarkets item = JsonConvert.DeserializeObject<MiscMarkets>(json);

            TestContext.WriteLine(item.UpdateTime.ToString());

            foreach(MiscMarket market in item.Market)
            {
                TestContext.WriteLine($"     {market.Name, -10}: {market.Price,10} {market.Change,10} {market.Percent,10}%");
            }
        }

        [TestMethod]
        public void MetalsFileRead()
        {
            using StreamReader r = new("JsonFileExamples/metals.json");
            string json = r.ReadToEnd();
            MetalsMarkets item = JsonConvert.DeserializeObject<MetalsMarkets>(json);

            TestContext.WriteLine($"{item.MarketStatus}  :  {item.UpdateTime}");

            foreach (MetalsMarket market in item.Market)
            {
                TestContext.WriteLine($"     {market.Name,-10}:{market.Ask,10}{market.Bid,10}{market.High,10}{market.Low,10}{market.Change,10}{market.Percent,10}%");
            }
        }
    }

}
