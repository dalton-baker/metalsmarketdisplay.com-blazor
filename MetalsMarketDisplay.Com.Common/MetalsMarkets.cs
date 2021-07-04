
using MetalsMarketDisplay.Com.Common.JsonConverters;
using System;
using System.Collections.Generic;
using System.Text.Json.Serialization;

namespace MetalsMarketDisplay.Com.Common
{
    public class MetalsMarkets
    {
        public string MarketStatus { get; set; }
        public DateTimeOffset UpdateTime { get; set; }
        public List<MetalsMarket> Market { get; set; }
    }

}
