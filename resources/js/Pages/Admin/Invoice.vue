<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import { mdiAccount, mdiAsterisk, mdiLabel, mdiNumeric } from "@mdi/js";

import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import {
    mdiAccountMultiple,
    mdiCartOutline,
    mdiChartTimelineVariant,
    mdiMonitorCellphone,
    mdiReload,
    mdiGithub,
    mdiChartPie,
} from "@mdi/js";
import * as chartConfig from "@/components/Charts/chart.config.js";
import LineChart from "@/components/Charts/LineChart.vue";
import SectionMain from "@/components/SectionMain.vue";
import CardBoxWidget from "@/components/CardBoxWidget.vue";
import CardBox from "@/components/CardBox.vue";
import TableSampleClients from "@/components/TableSampleClients.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxTransaction from "@/components/CardBoxTransaction.vue";
import CardBoxClient from "@/components/CardBoxClient.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/components/SectionBannerStarOnGitHub.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";

const chartData = ref(null);

const fillChartData = () => {
    chartData.value = chartConfig.sampleChartData();
};

onMounted(() => {
    fillChartData();
});

const mainStore = useMainStore();

const clientBarItems = computed(() => mainStore.clients.slice(0, 4));

const transactionBarItems = computed(() => mainStore.history);

const form = useForm({
    name: "",
    price: "",
});

const submit = () => {
    console.log("triggered");
    form.post(route("admin.invoices.store"));
    form.reset();
};

defineProps({
    invoices: {
        type: Array,
        default: () => [],
    },
});
const headers = ["Name", "Price"];
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Invoice" />

        {{ success }}

        <NotificationBarInCard v-if="success" color="success">
            {{ success }}
        </NotificationBarInCard>
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiple"
                title="Invoice"
            />
            <CardBox :class="cardClass" is-form @submit.prevent="submit">
                <FormValidationErrors />
                <FormField
                    label="Name"
                    label-for="name"
                    help="Input invoice name"
                >
                    <FormControl
                        v-model="form.name"
                        :icon="mdiLabel"
                        id="name"
                        autocomplete="name"
                        type="text"
                        required
                    />
                </FormField>

                <FormField
                    label="Price"
                    label-for="price"
                    help="Please enter the price"
                >
                    <FormControl
                        v-model="form.price"
                        :icon="mdiNumeric"
                        id="price"
                        autocomplete="price"
                        type="number"
                        required
                    />
                </FormField>
                <BaseLevel>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="info"
                            label="Add"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        />
                    </BaseButtons>
                </BaseLevel>
            </CardBox>
            <BaseDivider />

            <CardBox>
                <table>
                    <thead>
                        <tr>
                            <th v-for="header in headers" :key="header">
                                {{ header }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inv in invoices" :key="inv.id">
                            <td>{{ inv.name }}</td>
                            <td>{{ inv.price }}</td>
                        </tr>
                    </tbody>
                </table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
