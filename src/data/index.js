import { configureStore, combineReducers } from "@reduxjs/toolkit";
import { setupListeners } from "@reduxjs/toolkit/dist/query";
import auctionAPI from "./auctionAPI";

const store = configureStore({
    reducer: combineReducers({
        [auctionAPI.reducerPath]: auctionAPI.reducer,
    }),
});

setupListeners(store.dispatch);

export default store;
