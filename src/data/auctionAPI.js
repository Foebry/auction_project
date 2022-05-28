import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const auctionAPI = createApi({
    reducerPath: "auctionState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getAuctions: builder.query({
            query: ({ categories, page, page_count }) => {
                const query =
                    (categories && categories !== "") || page || page_count
                        ? "/auctions?"
                        : "/auctions";

                let params = [];

                if (categories) params = [...params, `cat_id=${categories}`];
                if (page) params = [...params, `page=${page}`];
                if (page_count)
                    params = [...params, `page_count=${page_count}`];

                params = params.join("&");

                return `${query}${params}`;
            },
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
        updateAuction: builder.mutation({
            query: ({ id, auc_expiration, csrf }) => ({
                url: `/auction/${id}`,
                method: "PATCH",
                body: {
                    auc_expiration,
                    csrf,
                },
                invalidatesTags: ["allAuctions"],
            }),
        }),
        updateAllAuctions: builder.mutation({
            query: (body) => ({
                url: "/auctions",
                method: "PATCH",
                body,
            }),
        }),
    }),
});

export default auctionAPI;
export const {
    useGetAuctionsQuery,
    useGetAuctionByIdQuery,
    useGetAuctionBiddingsByIdQuery,
    usePostAuctionMutation,
    useUpdateAuctionMutation,
    useUpdateAllAuctionsMutation,
} = auctionAPI;
