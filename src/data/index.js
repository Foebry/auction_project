import { configureStore, combineReducers } from "@reduxjs/toolkit";
import { setupListeners } from "@reduxjs/toolkit/dist/query";
import articleAPI from "./articleAPI";
import auctionAPI from "./auctionAPI";
import authenticationAPI from "./AuthenticationAPI";
import biddingAPI from "./biddingAPI";
import categoryAPI from "./categoryAPI";
import userAPI from "./userAPI";

const store = configureStore({
    reducer: combineReducers({
        [auctionAPI.reducerPath]: auctionAPI.reducer,
        [authenticationAPI.reducerPath]: authenticationAPI.reducer,
        [articleAPI.reducerPath]: articleAPI.reducer,
        [biddingAPI.reducerPath]: biddingAPI.reducer,
        [categoryAPI.reducerPath]: categoryAPI.reducer,
        [userAPI.reducerPath]: userAPI.reducer,
    }),
});

setupListeners(store.dispatch);

export default store;
