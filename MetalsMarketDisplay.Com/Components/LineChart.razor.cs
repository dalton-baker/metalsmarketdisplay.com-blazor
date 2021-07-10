using Microsoft.AspNetCore.Components;
using System;
using System.Collections.Generic;
using System.Linq;

namespace MetalsMarketDisplay.Com.Components
{
    public partial class LineChart
    {
        [Parameter]
        public string Height { get; set; }

        [Parameter]
        public string Width { get; set; }

        [Parameter]
        public List<double> Data { get; set; }

        [Parameter]
        public string LineColor { get; set; } = "#0000FF";

        [Parameter]
        public double? YStart { get; set; } = null;

        [Parameter]
        public double? YEnd { get; set; } = null;

        private int SvgAspectWidth => 1000;
        private int SvgAspectHeight => 500;

        private string GradientName { get; set; }
        private string LinePoints { get; set; }
        private string GradientPoints => $"0,{SvgAspectHeight} {LinePoints} {SvgAspectWidth},{SvgAspectHeight}";


        protected override void OnInitialized()
        {
            base.OnInitialized();
            GradientName = $"grad{Guid.NewGuid()}";
            LinePoints = CreateLinePoints();
        }

        private string CreateLinePoints()
        {
            double maxValue = YEnd ?? Data.OrderByDescending(d => d).First() * 1.001;
            double minValue = YStart ?? Data.OrderBy(d => d).First() * 0.999;

            double diff = maxValue - minValue;

            string linePoints = "";
            double XIncrement = (double)SvgAspectWidth / (Data.Count - 1);
            int i = 0;

            Data.ForEach(d => linePoints += $"{(int)(i++ * XIncrement)},{(int)(SvgAspectHeight - ((d - minValue) / diff * SvgAspectHeight))} ");
            return linePoints;
        }

    }
}
