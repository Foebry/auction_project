import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const biddingAPI = createApi({
    reducerPath: "biddingState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getBiddings: builder.query({
            query: () => "/biddings",
            providesTags: ["allBiddings"],
        }),
        postBiddings: builder.mutation({
            query: ({ bid_usr_id, bid_auc_id, bid_price, csrf }) => ({
                url: `/biddings`,
                method: "POST",
                body: {
                    bid_usr_id,
                    bid_auc_id,
                    bid_price,
                    csrf,
                },
            }),
            invalidatesTags: ["allBiddings"],
        }),
    }),
});

export default biddingAPI;
export const { useGetBiddingsQuery, usePostBiddingsMutation } = biddingAPI;
