const fs = require("fs");

(() => {
    try {
        const content = fs.readFileSync("src/mocks/auctions.js", "utf-8");
        const minute = 60 * 1000;
        const hour = 1000 * 60 * 60;
        const now = new Date().getTime();
        const dateInTenMins = new Date(now + 2 * hour + 10 * minute);
        const newDateString = dateInTenMins.toISOString();
        const newContent = content.replace(
            /expiration:.*,/g,
            `expiration: "${newDateString
                .substring(0, newDateString.length - 5)
                .split("T")
                .join(" ")}",`
        );
        fs.writeFileSync("src/mocks/auctions.js", newContent);
    } catch (error) {
        console.log(error);
    }
})();
