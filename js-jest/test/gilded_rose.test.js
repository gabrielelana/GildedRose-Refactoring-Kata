const { Shop, Item } = require("../src/gilded_rose");

describe("Golden Master", () => {
  it("should not change it's behaviour", done => {
    var fs = require("fs");
    var exec = require("child_process").execFile;

    fs.readFile(__dirname + "/GOLDEN_MASTER", "utf8", (err, content) => {
      let executable = __dirname + "/../bin/run.js";
      exec("node", [executable], (err, stdout, stderr) => {
        expect(content).toBe(stdout.toString());
        done();
      });
    });
  });
});

describe("Gilded Rose", () => {
  it("should foo", () => {
    const gildedRose = new Shop([new Item("foo", 0, 0)]);
    const items = gildedRose.updateQuality();
    expect(items[0].name).toBe("fixme");
  });
});
