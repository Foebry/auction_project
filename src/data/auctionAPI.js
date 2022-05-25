import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const auctionAPI = createApi({
    reducerPath: "auctionState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getAuctions: builder.query({
            query: () => "/auctions",
            providesTags: ["allAuctions"],
        }),
        getAuctionById: builder.query({
            query: (id) => `/auction/${id}`,
        }),
        getAuctionBiddingsById: builder.query({
            query: (id) => `/auction/${id}/biddings`,
        }),
        postAuction: builder.mutation({
            query: ({ auc_art_id, auc_expiration, csrf }) => ({
                url: `/auctions`,
                method: "POST",
                body: {
                    auc_art_id,
                    auc_expiration,
                    csrf,
                },
            }),
            invalidatesTags: ["allAuctions"],
        }),
    }),
});

export default auctionAPI;
export const {
    useGetAuctionsQuery,
    useGetAuctionByIdQuery,
    useGetAuctionBiddingsByIdQuery,
    usePostAuctionMutation,
} = auctionAPI;
