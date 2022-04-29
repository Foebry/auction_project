const fs = require("fs");


  (() => {
      try{
          const content = fs.readFileSync("src/mocks/auctions.js", "utf-8");
          const date = new Date();
          const dateInTenMins = new Date(date.getTime() + 240*60*1000 + 60000);
          const newDateString = dateInTenMins.toISOString();
          const newContent = content.replace(/expiration:.*,/g, `expiration: "${newDateString.substring(0, newDateString.length -5).split("T").join(" ")}",\n`);
          fs.writeFileSync("src/mocks/auctions.js", newContent);
          
      }
      catch(error){
        console.log(error);
      }
    })()