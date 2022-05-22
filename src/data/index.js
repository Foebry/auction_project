import { configureStore, combineReducers } from "@reduxjs/toolkit";
import { setupListeners } from "@reduxjs/toolkit/dist/query";
import auctionAPI from "./auctionAPI";
import authenticationAPI from "./AuthenticationAPI";

const store = configureStore({
    reducer: combineReducers({
        [auctionAPI.reducerPath]: auctionAPI.reducer,
        [authenticationAPI.reducerPath]: authenticationAPI.reducer,
    }),
});

setupListeners(store.dispatch);

export default store;