using MetalsMarketDisplay.Com.Common;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using Newtonsoft.Json;
using System;
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
            TestContext.WriteLine($"   USD:  {GetMiscCandleString(item.USD)}");
            TestContext.WriteLine($"   SPX:  {GetMiscCandleString(item.SPX)}");
            TestContext.WriteLine($"   COMP: {GetMiscCandleString(item.COMP)}");
            TestContext.WriteLine($"   DJIA: {GetMiscCandleString(item.DJIA)}");
            TestContext.WriteLine($"   BTC:  {GetMiscCandleString(item.BTC)}");
            TestContext.WriteLine($"   LTC:  {GetMiscCandleString(item.LTC)}");
            TestContext.WriteLine($"   ETH:  {GetMiscCandleString(item.ETH)}");
        }

        [TestMethod]
        public void MetalsFileRead()
        {
            using StreamReader r = new("JsonFileExamples/metals.json");
            string json = r.ReadToEnd();
            MetalsMarkets item = JsonConvert.DeserializeObject<MetalsMarkets>(json);

            TestContext.WriteLine($"{item.MarketOpen}  :  {item.UpdateTime}");
            TestContext.WriteLine($"   Gold:      {GetCandleString(item.Gold)}");
            TestContext.WriteLine($"   Silver:    {GetCandleString(item.Silver)}");
            TestContext.WriteLine($"   Platinum:  {GetCandleString(item.Platinum)}");
            TestContext.WriteLine($"   Palladium: {GetCandleString(item.Palladium)}");

        }

        private string GetCandleString(Candle candle)
        {
            return $"{candle.Ask, 10}{candle.Bid,10}{candle.Change,10}{candle.Percent,10}%{candle.High,10}{candle.Low,10}";
        }

        private string GetMiscCandleString(MiscCandle candle)
        {
            return $"{candle.Price,10}{candle.Change,10}{candle.Percent,10}";
        }
    }

}
